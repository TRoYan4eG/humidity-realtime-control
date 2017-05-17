<?php

namespace App\Http\Controllers;

use App\Sensor;
use App\Measurement;
use App\Straw;
use Illuminate\Http\Request;

class MeasurementsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straws = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->get();
        $sensors_final = [];
        foreach ($straws as $straw){
            $sensors = Sensor::where('straw_id', $straw->id)->get();
            if(count($sensors) > 1){
                foreach ($sensors as $sensor){
                    array_push($sensors_final, $sensor);
                }
            } else{
                array_push($sensors_final, $sensors);
            }
        }
        if(!count($sensors_final)){
            return $this->jsonResponse(['error' => 'You have no companies'], 404);
        }
        $measurements_final = [];
        foreach ($sensors_final as $sens){
            $measurements = Measurement::where('sensor_id', $sens->id)->get();
            if(count($measurements) > 1){
                foreach ($measurements as $measurement){
                    array_push($measurements_final, $measurement);
                }
            } else{
                array_push($measurements_final, $measurements);
            }
        }

        if(!count($measurements_final)){
            return $this->jsonResponse(['error' => 'You have no measurements'], 404);
        }
        return $this->jsonResponse($measurements_final,200);
    }

    public function show($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straws = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->get();
        $sensors_final = [];
        foreach ($straws as $straw){
            $sensors = Sensor::where('straw_id', $straw->id)->get();
            if(count($sensors) > 1){
                foreach ($sensors as $sensor){
                    array_push($sensors_final, $sensor);
                }
            } else{
                array_push($sensors_final, $sensors);
            }
        }
        if(!count($sensors_final)){
            return $this->jsonResponse(['error' => 'You have no companies'], 404);
        }
        $measurement = Measurement::find($id);

        foreach ($sensors_final as $sens){
            if ($sens->id == $measurement->sensor_id){
                return $this->jsonResponse($measurement, 200);
            }
        }
        return $this->jsonResponse(['error' => 'You have no permissions'], 403);
    }
}
