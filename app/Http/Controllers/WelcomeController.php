<?php

namespace App\Http\Controllers;

use App\Model\Group;
use App\Model\Problem;
use App\Model\SubscriptionPlan;
use App\Model\Therapist;
use App\Model\TherapistSchedule;
use App\Rules\TherapistSlugPresent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class WelcomeController extends Controller
{
    //
    public function index(){
        $problems=Problem::pluck('name','id')->all();
        $groups=Group::pluck('name','id')->all();


        return view('newWelcome',compact(['problems','groups']));
    }

    public function search(Request $request){
        $this->validate($request,[
           'latLng'=>'required|string',
           'problem_id'=>'required|string',
            'group_id'=>'required|string'
        ]);
        $input = $request->all();
        $input["latlng"]=json_decode($input["latLng"]);
        $result=DB::table("therapist_profiles")
            ->join("therapist_problems","therapist_profiles.therapist_id","=","therapist_problems.therapist_id")
            ->join("therapist_groups","therapist_profiles.therapist_id","=","therapist_groups.therapist_id")
            ->select("therapist_profiles.*"
                ,DB::raw("6371 * acos(cos(radians(" . $input['latlng']->lat . ")) 
        * cos(radians(latitude)) 
        * cos(radians(longitude) - radians(" . $input['latlng']->lng . ")) 
        + sin(radians(" .$input['latlng']->lat. ")) 
        * sin(radians(latitude))) AS distance"))

            ->having('distance',"<",20)
            ->where('therapist_groups.group_id',$request->group_id)
            ->where('therapist_problems.problem_id',$request->problem_id)
            ->orderBy('distance')
            ->get();
        $therapists=[];
        $positions=[];
        //dd($result);
        foreach ($result as $item){
           $therapist=Therapist::find($item->therapist_id);
           $therapist->distance=$item->distance;
           $latlng=new \stdClass();
           $latlng->lat=$therapist->profile->latitude;
            $latlng->lng=$therapist->profile->longitude;
            if($therapist->canUse()){
                array_push($therapists,$therapist);
                array_push($positions,$latlng);
            }

        };


        if(!$request->has('page'))
            $page=1;
        else $page=$request->page;
        $total = sizeof($therapists);
        $perPage =10;

        $therapists=$this->paginate($therapists,$perPage,$page);

        $mapsData =  [];
        foreach ($therapists as $therapist){
            $tempObj = new \stdClass();
            $tempObj->name=$therapist->name;
            $tempObj->location_latitude=$therapist->profile->latitude;
            $tempObj->location_longitude=$therapist->profile->longitude;
            $tempObj->map_image_url= $therapist->profile->dp?'/'.$therapist->profile->dp:'/theme/img/doctor_listing_1.jpg';
            $tempObj->type= 'therapist';
            $tempObj->url_detail= '/therapist-profile/'.$therapist->slug;
            $tempObj->name_point=$therapist->name;
            $tempObj->postCode=$therapist->profile->postal_code?$therapist->profile->postal_code:'';
            $tempObj->description_point= $therapist->completeAddress();
            $tempObj->get_directions_start_address= $input['latlng']->lat.','.$input['latlng']->lng;
            $tempObj->phone= $therapist->profile->contact?$therapist->profile->contact:'';
            array_push($mapsData,$tempObj);
        }
        $mapsData=json_encode($mapsData);
        //dd($mapsData);
        //dd($therapists->all());






        return view('searchResult',compact([
            'therapists',
            'total',
            'perPage',
            'positions'
            ,'mapsData',
            'input'
        ]));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return (new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        ))->withPath('/search')->appends(Input::except(['page']));
    }

    public function therapistSearch(Request $request,$slug){
        $therapist=Therapist::findBySlugOrFail($slug);
        $profile=$therapist->profile;
        $specializations=collect($therapist->specializations);
        $sp1=collect();
        $sp2=collect();
        //dd($specializations->chunk(2)->all());
        $chunk=$specializations->chunk(2)->all();
        if(sizeof($chunk)>0)
            $sp1=$chunk[0];
        if(sizeof($chunk)>1)
            $sp12=$chunk[1];

        $educations = $therapist->educations;
        $services = $therapist->services;
        $reviews=$therapist->reviews()->orderBy('created_at','DESC')->get();
        $stars=$therapist->getStars();
        $starsP=$therapist->getStarPercentages();


        return view('guest.newProfile',compact([
            'therapist',
            'profile',
            'sp1',
            'sp2',
            'chunk',
            'educations',
            'services',
            'reviews',
            'stars',
            'starsP'
        ]));
    }

    public function searchByDateAndSlug(Request $request){
        $validator = Validator::make($request->all(), [
            'date'=>'required|date',
            'slug'=>['required',new TherapistSlugPresent]

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $thrapist=Therapist::findBySlug($request->slug);
        $schedule=TherapistSchedule::where('date',$request->date)->where('therapist_id',$thrapist->id)->first();

        if($schedule){
            $schedule->time=explode('|',$schedule->times);
            return response()->json($schedule,200);
        }
        else {
            $carbon=Carbon::parse($request->date);
            $day=$carbon->dayOfWeekIso;
            $repeatDay = TherapistSchedule::where('day_number',$day)->where('therapist_id',$thrapist->id)
                ->where('repeat',1)
                ->first();
            if($repeatDay) {
                $repeatDay->time=explode('|',$repeatDay->times);
                return response()->json($repeatDay, 200);
            }
            else return response()->json("Empty",404);
        }
    }

    public function plans(){
        $plans= SubscriptionPlan::all();
        foreach ($plans as $p){
            $p->desc= explode("|",$p->description);
        }
        return view('plans',compact(['plans']));
    }

    public function newSchedule(Request $request){
        $validator = Validator::make($request->all(), [
            'date'=>'required|date',
            'slug'=>['required',new TherapistSlugPresent],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $therapist=Therapist::findBySlugOrFail($request->slug);
        $counter=5;
        $startDate=Carbon::parse($request->date);
        $startDate=$startDate->subDay(1);
        $dates=[];
        for($i=1;$i<=$counter;$i++){
            $obj=new \stdClass();
            $date=$startDate->addDay(1);
            /*if($date->eq(Carbon::now()))
                $obj->date='Today';
            else $obj->date=$date->format('D / d-m');*/
            $obj->date=$date->format('d-m-Y');
            $s=$therapist->schedules()->where('date',$date->toDateString())->first();
            if($s){

                $obj->times=explode("|",$s->times);
            }
            else {

                $obj->times=[];
            }
            array_push($dates,$obj);
        }
        return response()->json($dates,200);
    }

    public function terms(){
        return view('terms');
    }

    public function privacyPolicy(){
        return view('privacy');
    }
}
