<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyQuestion;
use App\Http\Requests\SurveyResponseStoreRequest;
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

    public function store(SurveyResponseStoreRequest $request, Survey $survey)
    {
        foreach ($request->validated()['response'] as $id => $value) {
            $question = SurveyQuestion::find($id);
            if (is_null($question)) {
                return redirect()->back()->withError("Ongeldige question-id '{$id}' meegegeven.");
            }

            $question->answers()->create([
                'response' => $value,
                'user_id' => \Auth::user()->id,
            ]);
        }

        return redirect()->route('home')->withSuccess('Je antwoord is opgeslagen.');
    }
}
