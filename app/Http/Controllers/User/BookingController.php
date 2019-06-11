<?php

namespace App\Http\Controllers\User;

use App\Model\Booking;
use App\Model\Therapist;
use App\Rules\TherapistSlugPresent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        /*$validator = Validator::make($request->all(), [
            'date'=>'required|date|after:yesterday',
            'slug'=>['required',new TherapistSlugPresent],
            'time'=>['required','string'],
            'description'=>['nullable','string'],
            'treatments'=>['nullable','string'],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();
            $user=Auth::user();
            $theapist=Therapist::findBySlug($request->slug);
            $time=str_replace(".",":",$request->time);
            $carbonTime=Carbon::createFromFormat("h:ia",$time);
            $booking = new Booking();
            $booking->user_id=$user->id;
            $booking->therapist_id=$theapist->id;
            $booking->date=$request->date;
            $booking->time=$carbonTime->toTimeString();
            $booking->description=$request->description;
            $booking->treatments=$request->treatments;
            $booking->save();
            DB::commit();
            return response()->json($booking,200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }*/

        $this->validate($request,[
            'date'=>'required|date|after:yesterday',
            'slug'=>['required',new TherapistSlugPresent],
            'time'=>['required','string'],
            'treatments'=>['nullable','array'],
        ]);


        try{
            DB::beginTransaction();
            $user=Auth::user();
            $theapist=Therapist::findBySlug($request->slug);
            $carbonTime=Carbon::createFromFormat("h:i a",$request->time);
            $date = Carbon::createFromFormat("m/d/Y",$request->date);
            $booking = new Booking();
            $booking->user_id=$user->id;
            $booking->therapist_id=$theapist->id;
            $booking->date=$date;
            $booking->time=$carbonTime->toTimeString();
            $booking->treatments=implode("|",$request->treatments);
            $booking->save();
            DB::commit();
            return Redirect::back()->with('success','Booking Done');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
