<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyDashboardController extends Controller
{
    public function create()
    {   
        return view('create');
    }
}
