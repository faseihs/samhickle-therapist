<?php

namespace App\Http\Controllers\User;

use App\Model\Review;
use App\Model\Therapist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ReviewController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function create($slug){
        $therapist=Therapist::findBySlugOrFail($slug);
        $user=Auth::user();
        return view('user.submit-review',compact([
            'therapist',
            'user'
        ]));
    }

    public function store(Request $request,$slug){
        $this->validate($request,[
           'stars'=>'required|numeric',
           'review'=>'required|string',
           'accept'=>'required'
        ]);

        $therapist=Therapist::findBySlugOrFail($slug);
        $user=Auth::user();

        if(!$user->canReview($therapist))
            return Redirect::back()->withErrors('cannot-post','You cannot post a review without a successful booking');
        try{
            DB::beginTransaction();
            $input=$request->except('accept');
            $input['user_id']=$user->id;
            $input['therapist_id']=$therapist->id;
            $review= new Review($input);
            $review->save();
            DB::commit();
            return redirect('/therapist-profile/'.$therapist->slug)->with('success','Added Review');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
}
