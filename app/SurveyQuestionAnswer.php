<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    protected $fillable = ['response', 'room', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\SurveyQuestion', 'survey_question_id');
    }
}
