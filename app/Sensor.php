<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Sensor extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lat', 'lng', 'straw_id',
    ];

    public function owner(){
        $this->hasOne('App\Straw', 'straw_id');
    }
}
