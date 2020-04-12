<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function surveys()
    {
        return view('results.surveys');
    }
}
