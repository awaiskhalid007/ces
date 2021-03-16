<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class calendarsController extends Controller
{
    public function index()
    {
    	return view('dashboard.calendar');
    }
}
