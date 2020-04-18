<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRangeToQuestion extends Migration
{
    public function up()
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->integer('min')->default(0);
            $table->integer('max')->default(10);
        });
    }

    public function down()
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->dropColumn(['min', 'max']);
        });
    }
}
