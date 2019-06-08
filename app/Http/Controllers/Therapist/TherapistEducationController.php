<?php

namespace App\Http\Controllers\Therapist;

use App\Model\TherapistEducation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TherapistEducationController extends Controller
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
        $educations=$therapist->educations;
        $profile=$therapist->profile;
        $services=$therapist->services;

        return view('therapist.education.index',compact(['services','therapist','educations','profile']));

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
            'college'=>'required|string',
            'description'=>'required|string'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();
            $therapist=Auth::user();
            $education=new TherapistEducation($request->all());
            $education->therapist_id=$therapist->id;
            $education->save();
            DB::commit();
            return response()->json($education,201);
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
        header('Content-Type: application/json; charset=utf-8');
        $validator = Validator::make($request->all(), [
            'college'=>'required|string',
            'description'=>'required|string'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();

            $service=TherapistEducation::findOrFail($id);
            $service->update($request->all());
            DB::commit();
            return response()->json($service,201);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
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
        TherapistEducation::findOrFail($id)->delete();
        return response()->json("Done",200);
    }
}
