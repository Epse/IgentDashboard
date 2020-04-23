<?php

namespace App\Http\Controllers;

use App\SurveyQuestion;
use App\SurveyQuestionAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyQuestionAnswerController extends Controller
{
    public function index(Request $request, SurveyQuestion $question)
    {
        if (! $request->has('since')) {
            return $question->answers;
        }
        try {
            $since = Carbon::parse($request->get('since'));
            return $question->answers()->where('created_at', '>',
                                               $since->toDateTimeString())
                            ->get();
        } catch (\Exception $e) {
            abort(403, "Bad timestamp passed. Message: {$e->getMessage()}");
        }
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
