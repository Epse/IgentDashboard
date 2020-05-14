<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\SensorType;
use App\Sensor;
use App\SensorDatapoint;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view data');
    }

    public function index()
    {
        return view('rooms.index');
    }

    public function show(string $room)
    {
        // TODO: validate room
        $feedbacks = Feedback::where('room', $room)->orderBy('created_at', 'desc')->paginate(25);
        $types = SensorType::all();
        $currentValues = [];
        foreach ($types as $type) {
            $ids = $type->sensors()->where('room', $room)->pluck('id')->all();
            $measurement = SensorDatapoint::whereIn('sensor_id', $ids)->orderBy('created_at', 'desc')->first();
            if (! is_null($measurement)) {
                $currentValues[$type->type] = $measurement->value;
            }
        }
        return view('rooms.show', compact('room', 'feedbacks', 'currentValues'));
    }
}
