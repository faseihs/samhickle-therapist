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
        foreach ($result as $item){
           $therapist=Therapist::find($item->id);
           $therapist->distance=$item->distance;
           array_push($therapists,$therapist);
        };
        if(!$request->has('page'))
            $page=1;
        else $page=$request->page;
        $total = sizeof($therapists);
        $perPage =10;
        $therapists=$this->paginate($therapists,$perPage,$page);



        return view('searchResult',compact([
            'therapists',
            'total',
            'perPage'
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
