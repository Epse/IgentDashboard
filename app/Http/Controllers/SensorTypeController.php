<?php

namespace App\Http\Controllers;

use App\SensorType;
use Illuminate\Http\Request;

class SensorTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view data');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SensorType::all();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function show(SensorType $sensorType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function edit(SensorType $sensorType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SensorType $sensorType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SensorType $sensorType)
    {
        //
    }
}
