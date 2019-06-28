<?php

namespace App\Http\Controllers\Therapist;

use App\Mail\ToPatient;
use App\Model\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:therapist');
        $this->middleware('therapistCanUse');
    }

    public function index(Request $request){

        $status="all";
        $therapist=Auth::user();
        if($request->has('status')) {
            $status = $request->status;
            $availableStatus=['all',0,1,2];
            if(!in_array($status,$availableStatus)){
                abort("404","Status Not Correct");
            }
        }
        if($status=='all')
            $bookings=$therapist->bookings()->orderBy('created_at','DESC')->paginate(5);
        else $bookings=$therapist->bookings()->where('status',$status)->orderBy('created_at','DESC')->paginate(5);


        return view('therapist.booking.index',compact([
            'status',
            'therapist',
            'bookings'
        ]));

    }

    public function update(Request $request,$id){
        $booking=Booking::findOrFail($id);
        $this->validate($request,[
           'status'=>'required'
        ]);

        try{
            DB::beginTransaction();
            $booking->update($request->all());
            DB::commit();
            if($booking->status==0)
                $booking->Status="stalled";
            else if($booking->status==1)
                $booking->Status="approved";
            else if($booking->status==2)
                $booking->Status="cancelled";
            try{
                $user=$booking->user;
                Mail::to($user->email)->send(new ToPatient($user,"",$booking));

            }
            catch (\Exception $e){
                dd($e);
            }
            return Redirect::back()->with('success','Successfully Updated');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
}
