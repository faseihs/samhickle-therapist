<?php

namespace App\Http\Controllers\User;

use App\Model\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        return redirect('/user/bookings');
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

        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }

        if($request->has('password') && $request->password!=null){
            $this->validate($request,[
                'password' => ['required','string','min:8','confirmed']
            ]);

            if(Hash::check($request['password'],$user->getAuthPassword()))
                return Redirect::back()->withInput(Input::all())->withErrors(['','New Password same to old password']);
            $user->password=bcrypt($request->password);
            $user->save();
        }
        return redirect('/user/edit-profile')
            ->with('success','Updated');
    }

    public function bookings( Request $request){
        $status="all";
        $user=Auth::user();
        if($request->has('status')) {
            $status = $request->status;
            $availableStatus=['all',0,1,2];
            if(!in_array($status,$availableStatus)){
                abort("404","Status Not Correct");
            }
        }
        if($status=='all')
            $bookings=$user->bookings()->orderBy('created_at','DESC')->paginate(5);
        else $bookings=$user->bookings()->where('status',$status)->orderBy('created_at','DESC')->paginate(5);


        return view('user.dashboard.bookings',compact([
            'status',
            'user',
            'bookings'
        ]));
    }

    public function reviews(Request $request){
        $user=Auth::user();
        $type="latest";
        if($request->get('type'))
            $type=$request->type;
        if($type=='latest')
            $reviews=$user->reviews()->where('created_at','>=',Carbon::now()->subDay(7)->toDateString())
                ->orderBy('created_at','DESC')->paginate(10);
        else $reviews=$user->reviews()->where('created_at','<=',Carbon::now()->subDay(7)->toDateString())
            ->orderBy('created_at','DESC')->paginate(10);

        return view('user.dashboard.reviews',
            compact([
                'user',
                'reviews',
                'type'
            ]));
    }

    public function updateBooking(Request $request,$id){
        $booking=Booking::findOrFail($id);
        $this->validate($request,[
            'status'=>'required'
        ]);

        try{
            DB::beginTransaction();
            $booking->delete();
            DB::commit();
            return Redirect::back()->with('success','Successfully Updated');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
}
