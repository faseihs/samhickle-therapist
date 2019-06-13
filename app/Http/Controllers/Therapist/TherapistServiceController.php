<?php

namespace App\Http\Controllers\Therapist;

use App\Model\TherapistService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TherapistServiceController extends Controller
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
        $services=$therapist->services;
        $specializations = $therapist->specializations;
        //dd($specializations);
        return view('therapist.services.index',compact(['specializations','therapist','services']));

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
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'service'=>'required|string',
            'price'=>'required|numeric'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();
            $therapist=Auth::user();
            $service=new TherapistService($request->all());
            $service->therapist_id=$therapist->id;
            $service->save();
            DB::commit();
            return response()->json($service,201);
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
            'service'=>'required|string',
            'price'=>'required|numeric'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try{
            DB::beginTransaction();

            $service=TherapistService::findOrFail($id);
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
        TherapistService::findOrFail($id)->delete();
        return response()->json("Done",200);
    }

    public function editAnyProfileDetail(Request $request){
        try{
            DB::beginTransaction();
            $therapist=Auth::user();
            $therapist->profile->update($request->except('redirectPath'));
            DB::commit();
            return Redirect::back()->with('success','Updated');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
}
