<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            // We want the latest surveys first
            'surveys' => Survey::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
