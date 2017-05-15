<?php

namespace App;

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

    public function owner(){
        $this->hasOne('App\Company', 'company_id');
    }
}
