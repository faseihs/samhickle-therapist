<?php

namespace App\Http\Controllers\Therapist;

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
       return view('therapist.dashboard.index');
    }

    public function editProfile(){
        $therapist = Auth::user();
        $profile=$therapist->profile;
        return view('therapist.dashboard.edit-profile',compact(['therapist','profile']));
    }

    public function updateProfile(Request $request){
        //dd($request->all());
        $therapist=Auth::user();
        $profile=$therapist->profile;
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'unique:therapists,email,'.$therapist->id,
            'contact'=>'nullable|string',
            'dp'=>'nullable|image'
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

}
