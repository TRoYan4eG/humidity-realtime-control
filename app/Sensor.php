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

    public $table = 'sensors';

    public function straw(){
        return $this->belongsTo('App\Straw');
    }

    public function measurements(){
        return $this->hasMany('App\Measurement', 'sensor_id');
    }

    public function getMeasurements(){

        $measurement_data_html = file_get_contents("https://weather.com/ru-RU/weather/today/l/$this->lat,$this->lng");
       // preg_match_all("/<div\s*class=\".*today_nowcard-sidecar.*\">.+<span>\s*(\d+)\s*<span\s*class=\".*percent-symbol.*\">.+<\/div>/", $measurement_data_html, $humidity);
        preg_match_all("/<tr>\s*<th>Влажность<\/th>\s*<td>\s*<span class=\"\"><span>(\d+)<span class=\"percent-symbol\">%<\/span>\s*<\/span>\s*<\/span>\s*<\/td>\s*<\/tr>/usi", $measurement_data_html, $humidity);
        preg_match_all("/<div\s*class=\"today_nowcard-temp\">\s*<span\s*class=\"\">(\d+)<sup>.*°.*<\/sup>\s*<\/span>\s*<\/div>/u", $measurement_data_html, $temperature);
        $measurement = new Measurement;
        $measurement->temperature = round($temperature[1][0], 2);
        $measurement->humidity = round($humidity[1][0], 2);
        $measurement->sensor_id = $this->id;
        $measurement->save();
    }
}
