<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['title', 'description'];

    public function questions()
    {
        return $this->hasMany('App\SurveyQuestion');
    }

    // True if the current user has submitted an answer for this survey
    public function getAnsweredAttribute()
    {
        $answers = DB::table('surveys')
                 ->where('surveys.id', $this->id)
                 ->join('survey_questions', 'surveys.id', '=', 'survey_questions.survey_id')
                 ->join('survey_question_answers', 'survey_questions.id', '=', 'survey_question_answers.survey_question_id')
                 ->where('survey_question_answers.user_id', \Auth::user()->id)
                 ->groupBy('survey_questions.id')
                 ->selectRaw('survey_questions.id as id, count(*) as count')
                 ->get();
        return $answers->count() == $this->questions->count() &&
                                 $answers->reduce(function ($carry, $item) {
                                     return $carry && $item->count > 0;
                                 }, true);
    }
}
