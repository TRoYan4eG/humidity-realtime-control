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
        return view('site.company.index', ['companies' => $companies]);
    }

}
