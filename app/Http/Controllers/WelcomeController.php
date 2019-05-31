<?php

namespace App\Http\Controllers;

use App\Model\Group;
use App\Model\Problem;
use App\Model\Therapist;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class WelcomeController extends Controller
{
    //
    public function index(){
        $problems=Problem::pluck('name','id')->all();
        $groups=Group::pluck('name','id')->all();

        return view('newWelcome',compact(['problems','groups']));
    }

    public function search(Request $request){
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

            ->having('distance',"<",500)
            ->where('therapist_groups.group_id',$request->group_id)
            ->where('therapist_problems.problem_id',$request->problem_id)
            ->orderBy('distance')
            ->get();
        $therapists=[];
        $positions=[];
        foreach ($result as $item){
           $therapist=Therapist::find($item->id);
           $therapist->distance=$item->distance;
           $latlng=new \stdClass();
           $latlng->lat=$therapist->profile->latitude;
            $latlng->lng=$therapist->profile->longitude;
           array_push($therapists,$therapist);
            array_push($positions,$latlng);
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
            $tempObj->map_image_url= '/theme/img/doctor_listing_1.jpg';
            $tempObj->type= 'therapist';
            $tempObj->url_detail= 'detail-page.html';
            $tempObj->name_point=$therapist->name;
            $tempObj->description_point= '35 Newtownards Road, Belfast, BT4.';
            $tempObj->get_directions_start_address= '';
            $tempObj->phone= '+3934245255';
            array_push($mapsData,$tempObj);
        }
        $mapsData=json_encode($mapsData);






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
}
