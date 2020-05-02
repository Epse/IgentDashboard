<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorDatapointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_datapoints', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('sensor_id');
            $table->foreign('sensor_id')
                  ->references('id')
                  ->on('sensors')
                  ->onDelete('CASCADE');

            $table->double('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_datapoints');
    }
}
