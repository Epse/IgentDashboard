<?php

namespace App\Http\Controllers;

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
        return view('rooms.show', [
            'room' => $room,
        ]);
    }
}
