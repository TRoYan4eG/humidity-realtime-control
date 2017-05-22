<?php

namespace App\Http\Controllers;

use App\Company;
use App\Straw;
use Illuminate\Http\Request;

class StrawsController extends Controller
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
        if(!$straws){
            return $this->jsonResponse(['error' => 'You have no straws'], 404);
        }
        return $this->jsonResponse($straws,200);
    }

    public function show($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $straw = Straw::with(['company' => function($query) {
            $query->where('owner_id', \Auth::user()->id);
        }])->find($id);
        if(!$straw){
            return $this->jsonResponse(['error' => 'You have no permissions'], 403);
        }
        return $this->jsonResponse($straw, 200);
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
