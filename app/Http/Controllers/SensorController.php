<?php

namespace App\Http\Controllers;

use App\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SensorController extends Controller
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
    public function index(Request $request)
    {
        $query = Sensor::with('type');
        if ($request->has('room')) {
            $query->where('room', $request->get('room'));
        }

        if ($request->has('type')) {
            $query->where('sensor_type_id', $request->get('type'));
        }

        if ($request->has('data')) {
            $query->with(['datapoints' => function($query) use ($request) {
                $query->orderBy('created_at', 'desc');
                if ($request->has('since')) {
                    $date = Carbon::parse($request->get('since'));
                    if ($date == false) {
                        abort(403, "Bad date");
                    }
                    $query->where('created_at', '>=', $date->toDateTimeString());
                }
                if ($request->has('until')) {
                    $date = Carbon::parse($request->get('until'));
                    if ($date == false) {
                        abort(403, "Bad date");
                    }
                    $query->where('created_at', '<=', $date->toDateTimeString());
                }
            }]);
        }

        return $query->get();
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
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
