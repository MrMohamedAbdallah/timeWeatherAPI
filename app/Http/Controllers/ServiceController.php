<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    /**
     * Return the time and wather information in JSON format
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function timeAndWeather(Request $request){

        // Validate request
        $requestResults = Validator::make($request->all(), [
            'lat'   => 'required|numeric',
            'lng'   => 'required|numeric'
        ]);

        // Abort if it's a bad request
        if($requestResults->fails()){
            return response()->json([
                'errors'    => $requestResults->errors()
            ], 400);
        }

        $lat = $request->lat;
        $lng = $request->lng;
        
        $data = []; // The data that will be send to the user
        

        
        $client = new Client();  // Create new client

        // Sending a request the weather API with test data
        $weatherRequest = $client->get('https://www.metaweather.com/api/location/search/', [
            'query' => [
                'lattlong'   => $lat . ',' . $lng
            ]
        ]);

        if($weatherRequest->getStatusCode() == 200){
            // Convert the data to object
            $weatherData = json_decode($weatherRequest->getBody());
            $data['weather'] = $weatherData;
        } else {
            return response()->json([
                'errors'    => [
                    'weather'   => [
                        'Error while connecting to the weather API'
                    ]
                ]
            ], 500);
        }

        $timeRequest = $client->get('https://api.ipgeolocation.io/timezone',[
            'query' => [
                'apiKey' => env('TIME_API_KEY'),
                'lat' => $lat,
                'long' => $lng,

            ]
        ]);

        if($timeRequest->getStatusCode() == 200){
            // Convert the data to object
            $timeData = json_decode($timeRequest->getBody());
            $data['time'] = $timeData;
        } else {
            return response()->json([
                'errors'    => [
                    'time'   => [
                        'Error while connecting to the time API'
                    ]
                ]
            ], 500);
        }

        return response()->json($data, 200);        
    }
}
