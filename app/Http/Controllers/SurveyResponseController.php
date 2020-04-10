<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fill(Survey $survey)
    {
        return view('surveys.fill', [
            'survey' => $survey,
            'questions' => $survey->questions,
        ]);
    }

    public function store(Request $request, Survey $survey)
    {
        dd($request);
    }
}
