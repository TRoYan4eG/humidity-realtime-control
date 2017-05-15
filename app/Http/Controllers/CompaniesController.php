<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
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
        $companies = Company::where('owner_id', $user->id)->get();
        if(!$companies){
            return $this->jsonResponse(['error' => 'You have no companies'], 404);
        }
        return $this->jsonResponse($companies,200);
    }

    public function show($id){
        $user = \Auth::user();
        if (!$user){
            return $this->jsonResponse(['error' => 'You are not authorized!'], 400);
        }
        $company = Company::where('owner_id', $user->id)->find($id);
        if(!$company){
            return $this->jsonResponse(['error' => 'You have no permissions'], 403);
        }
        return $this->jsonResponse($company, 200);
    }
}
