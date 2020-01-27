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
        $data = []; // The data that will be send to the user
        
        // Data for testing
        $lat = 30.0444;
        $lng = 31.2357;

        
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


        return response()->json($data, 200);
        
    }
}
