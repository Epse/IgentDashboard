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
        $query = $question->answers();
        if ($request->has('since')) {
            try {
                $since = Carbon::parse($request->get('since'));
                $query = $query->where('created_at', '>',
                                       $since->toDateTimeString());
            } catch (\Exception $e) {
                abort(403, "Bad timestamp passed. Message: {$e->getMessage()}");
            }
        }

        if ($request->has('room')) {
            $query->where('room', $request->get('room'));
        }
        return $query->get();
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
