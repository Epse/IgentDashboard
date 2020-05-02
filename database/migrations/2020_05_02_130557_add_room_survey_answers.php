<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomSurveyAnswers extends Migration
{
    public function up()
    {
        Schema::table('survey_question_answers', function (Blueprint $table) {
            $table->string('room');
        });
    }

    public function down()
    {
        Schema::table('survey_question_answers', function (Blueprint $table) {
            $table->dropColumn('room');
        });
    }
}
