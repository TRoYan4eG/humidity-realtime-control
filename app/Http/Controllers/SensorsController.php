<?php

namespace App\Http\Controllers;

use App\Straw;

class SensorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straws = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->with(['sensors' => function($query2){
            $query2->with('measurements');
        }])->find($id);
        $sensors = $straws->sensors->all();
        return $this->jsonResponse(['success' => true, 'sensors' => $sensors[0]], 200);
    }

    public function getSensorsData(){
        return view('site.sensors.index');
    }
}
