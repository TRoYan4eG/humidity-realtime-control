<?php

namespace App\Http\Controllers;

use App\Straw;

class StrawsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function companyStraws($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straws = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->where('company_id', $id)->get();
        return view('site.straw.index', ['straws' => $straws]);
    }
}
