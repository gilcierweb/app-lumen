<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index(){
        return response()->json(['message' => 'Home API']);
    }
}