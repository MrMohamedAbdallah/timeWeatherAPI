<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ServiceController extends Controller
{

    /**
     * Return the time and wather information in JSON format
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function timeAndWeather(Request $request){
        
    }
}
