<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        $zipCode = $request->zip;
      
        // dd($zipCode);
        return response()->json(['message' => '/search/local/CEP-1,CEP-2…','data' => $zipCode,]);
    }

    private function searchZipCode(string $zipCode) {
        
    }
}