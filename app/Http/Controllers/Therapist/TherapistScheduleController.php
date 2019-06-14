<?php

namespace App\Http\Controllers\Therapist;

use App\Model\TherapistSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TherapistScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:therapist');
        $this->middleware('therapistCanUse');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $therapist=Auth::user();
        $profile=$therapist->orofile;
        $schedules=$therapist->schedules;
        return view('therapist.schedule.index',compact(['therapist','profile','schedules']));
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
        $validator = Validator::make($request->all(), [
            'date'=>'required|date',
            'times'=>'required|string',
            'repeat'=>'nullable|numeric'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();
            $therapist= Auth::user();
            if($already=TherapistSchedule::where('date',$request->date)->where('therapist_id',Auth::user()->id)->first())
            {
                $carbon=Carbon::parse($request->date);
                $already->day_name=$carbon->dayName;
                $already->day_number=$carbon->dayOfWeekIso;
                $already->update($request->all());
            }

            else {
                $new =new TherapistSchedule($request->all());
                $carbon=Carbon::parse($request->date);
                $new->day_name=$carbon->dayName;
                $new->day_number=$carbon->dayOfWeekIso;
                $therapist->schedules()->save($new);
            }
            DB::commit();
            return response()->json("Done",200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
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


    public function searchByDate(Request $request){
        $validator = Validator::make($request->all(), [
            'date'=>'required|date'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $schedule=TherapistSchedule::where('date',$request->date)->where('therapist_id',Auth::user()->id)->first();

        if($schedule){
            $schedule->time=explode('|',$schedule->times);
            return response()->json($schedule,200);
        }
        else {
            $carbon=Carbon::parse($request->date);
            $day=$carbon->dayOfWeekIso;
            $repeatDay = TherapistSchedule::where('day_number',$day)->where('therapist_id',Auth::user()->id)
                ->where('repeat',1)
                ->first();
            $repeatDay=null;
            if($repeatDay) {
                $repeatDay->time=explode('|',$repeatDay->times);
                return response()->json($repeatDay, 200);
            }
             else return response()->json("Empty",404);
        }
        //
    }
}
