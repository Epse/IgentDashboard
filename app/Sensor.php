<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public $timestamps = false;
    protected $fillable = ['unit', 'name', 'name', 'type', 'room'];

    public function datapoints()
    {
        return $this->hasMany('App\SensorDatapoint');
    }

    public function type()
    {
        return $this->belongsTo('App\SensorType', 'sensor_type_id');
    }
}
