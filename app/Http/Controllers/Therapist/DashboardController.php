<?php

namespace App\Http\Controllers\Therapist;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:therapist');
    }

    public function index(){
        return redirect('/therapist/bookings');

        return view('therapist.dashboard.index');
    }

    public function editProfile(){
        $therapist = Auth::user();
        $profile=$therapist->profile;
        return view('therapist.dashboard.edit-profile',compact(['therapist','profile']));
    }

    public function updateProfile(Request $request){
        $therapist=Auth::user();
        $profile=$therapist->profile;
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'unique:therapists,email,'.$therapist->id,
            'contact'=>'nullable|string',
            'dp'=>'nullable|image',
            'city'=>'nullable|string',
            'state'=>'nullable|string',
            'address'=>'nullable|string',
            'postal_code'=>'nullable|string',
        ]);
        try{
            DB::beginTransaction();
            $therapist->name=$request->name;
            $therapist->email=$request->email;
            if($request->contact!=null) {
                $profile->contact=$request->contact;
            }


            if($request->has('delPic')){
                $p=$profile->dp;
                try {
                    unlink(public_path($p));
                }

                catch(\Exception $e){

                }
                $profile->dp=null;
            }



            if($file=$request->file('dp')){
                if($profile->dp){
                    $p=$profile->dp;
                    try {
                        unlink(public_path($p));
                    }

                    catch(\Exception $e){

                    }
                    $profile->dp=null;
                }


                $name=time().$file->getClientOriginalName();
                $path='images/therapists/'.$therapist->id;
                $file->move($path,$name);
                $profile->dp=$path.'/'.$name;
            }
            $profile->city=$request->city;
            $profile->state=$request->state;
            $profile->address=$request->address;
            $profile->postal_code=$request->postal_code;
            $therapist->save();
            $profile->save();
            DB::commit();
            return redirect('/therapist/edit-profile')
                ->with('success','Updated');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }

    public function reviews(Request $request){
        $therapist=Auth::user();
        $type="latest";
        if($request->get('type'))
            $type=$request->type;
        if($type=='latest')
            $reviews=$therapist->reviews()->where('created_at','>=',Carbon::now()->subDay(7)->toDateString())
                ->orderBy('created_at','DESC')->paginate(10);
        else $reviews=$therapist->reviews()->where('created_at','<=',Carbon::now()->subDay(7)->toDateString())
            ->orderBy('created_at','DESC')->paginate(10);

        return view('therapist.dashboard.reviews',
            compact([
                'therapist',
                'reviews',
                'type'
            ]));

    }

}
