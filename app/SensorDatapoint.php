<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorDatapoint extends Model
{
    protected $fillable = ['sensor_id', 'created_at', 'value'];

    public function sensor()
    {
        return $this->belongsTo('App\Sensor');
    }
}
