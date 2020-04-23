<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = ['unit', 'name', 'name', 'type', 'room'];

    public function datapoints()
    {
        return $this->hasMany('App\SensorDatapoint');
    }
}
