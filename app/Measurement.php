<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Measurement extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'temperature', 'humidity', 'sensor_id',
    ];

    public function owner(){
        $this->hasOne('App\Sensor', 'sensor_id');
    }
}
