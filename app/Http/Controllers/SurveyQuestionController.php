<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyQuestion;
use App\Http\Requests\StoreSurveyQuestionRequest;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        return $survey->questions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyQuestionRequest $request, Survey $survey)
    {
        $survey->questions()->create($request->validated());
        return redirect()->back()->withSuccess('Vraag succesvol aangemaakt');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @param  \App\SurveyQuestion  $question
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyQuestion $question)
    {
        return $question;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @param  \App\SurveyQuestion  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyQuestion $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @param  \App\SurveyQuestion  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyQuestion $question)
    {
        $question->delete();
        return redirect()->back()->withSuccess('Vraag verwijderd.');
    }
}
