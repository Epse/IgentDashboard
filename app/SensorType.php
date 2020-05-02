<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    public $timestamps = false;

    protected $fillable = ['unit', 'type'];

    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
}
