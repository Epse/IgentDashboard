<?php

namespace App\Http\Controllers;

use App\SurveyQuestion;
use App\SurveyQuestionAnswer;
use Illuminate\Http\Request;

class SurveyQuestionAnswerController extends Controller
{
    public function index(SurveyQuestion $question)
    {
        return $question->answers;
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SurveyQuestionAnswer $answer)
    {
        return $answer;
    }

    public function update(Request $request, SurveyQuestionAnswer $answer)
    {
        //
    }

    public function destroy(Survey $survey)
    {
        //
    }
}
