<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Straw extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'lat', 'lng', 'company_id',
    ];

    public $table = 'straws';

    public function company(){
       return $this->belongsTo('App\Company');
    }

    public function sensors(){
        return $this->hasMany('App\Sensor');
    }

    public function getSensorsReadings(){
        foreach ($this->sensors as $sensor){
            $sensor->getMeasurements();
        }
    }
}
