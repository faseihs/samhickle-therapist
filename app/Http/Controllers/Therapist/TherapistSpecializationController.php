<?php

namespace App\Http\Controllers\Therapist;

use App\Model\TherapistSpecialization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TherapistSpecializationController extends Controller
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
            'specialization'=>'required|string'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();
            $service=new TherapistSpecialization($request->all());
            $service->therapist_id=Auth::user()->id;
            $service->save();
            DB::commit();
            return response()->json($service,201);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getTrace(),500);
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
            'specialization'=>'required|string'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();

            $service=TherapistSpecialization::findOrFail($id);
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
        header('Content-Type: application/json; charset=utf-8');
        TherapistSpecialization::findOrFail($id)->delete();
        return response()->json("Done",200);
    }
}
