<?php

namespace App\Http\Controllers;

use App\Sensor;
use App\SensorDatapoint;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Sensor $sensor)
    {
        $query =  $sensor->datapoints()->orderBy('created_at', 'desc');

        if ($request->has('since')) {
            try {
                $since = Carbon::parse($request->get('since'));
                $query = $query->where('created_at', '>',
                                       $since->toDateTimeString());
            } catch (\Exception $e) {
                abort(403, "Bad timestamp passed. Message: {$e->getMessage()}");
            }
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SensorDatapoint  $sensorDatapoint
     * @return \Illuminate\Http\Response
     */
    public function show(SensorDatapoint $sensorDatapoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SensorDatapoint  $sensorDatapoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SensorDatapoint $sensorDatapoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SensorDatapoint  $sensorDatapoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(SensorDatapoint $sensorDatapoint)
    {
        //
    }
}
