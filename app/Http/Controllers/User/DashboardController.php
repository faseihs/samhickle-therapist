<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $user=Auth::user();
        return view('user.dashboard.index',compact([
            'user'
        ]));
    }

    public function editProfile(){
        $user = Auth::user();
        $profile=$user->profile;
        return view('user.dashboard.edit-profile',compact(['user','profile']));
    }

    public function updateProfile(Request $request){
        $user=Auth::user();
        $profile=$user->profile;
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'unique:users,email,'.$user->id,
            'contact'=>'nullable|string',
            'dp'=>'nullable|image',
            'city'=>'nullable|string',
            'state'=>'nullable|string',
            'address'=>'nullable|string',
            'postal_code'=>'nullable|string',
        ]);
        try{
            DB::beginTransaction();
            $user->name=$request->name;
            $user->email=$request->email;
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
                $path='images/users/'.$user->id;
                $file->move($path,$name);
                $profile->dp=$path.'/'.$name;
            }
            $profile->city=$request->city;
            $profile->state=$request->state;
            $profile->address=$request->address;
            $profile->postal_code=$request->postal_code;
            $user->save();
            $profile->save();
            DB::commit();
            return redirect('/user/edit-profile')
                ->with('success','Updated');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
}
