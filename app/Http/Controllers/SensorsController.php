<?php

namespace App\Http\Controllers;

use App\Company;
use App\Sensor;
use App\Straw;
use Illuminate\Http\Request;

class SensorsController extends Controller
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
        return $this->jsonResponse($sensors_final,200);
    }

    public function show($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straws = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->get();
        $sensor = Sensor::find($id);
        foreach ($straws as $straw){
            if($straw->id == $sensor->straw_id){
                return $this->jsonResponse($sensor, 200);
            }
        }
        return $this->jsonResponse(['error' => 'You have no permissions'], 403);
    }
}
