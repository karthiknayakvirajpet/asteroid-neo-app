<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class NeoFeedController extends Controller
{
    #*************************************************************************
    # Neo Feed View Page
    #*************************************************************************
    public function neoFeedView()
    {
        return view('neo_feed_view');
    }

    #*************************************************************************
    # Get Neo Feed based on date
    #*************************************************************************
    public function getNeoFeed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date_format:"Y-m-d"',
            'to_date' => 'required|date_format:"Y-m-d"|after_or_equal:from_date', 
        ]);

        if ($validator->fails())
        {
            return $validator->errors();
        }

        $headers[]='Content-Type: application/json';
        $url = 'https://api.nasa.gov/neo/rest/v1/feed?start_date='.$request->from_date.'&end_date='.$request->to_date.'&api_key=2uuaCtck9sfSzAbJr7sMz0waoqL465BurT2UHdpV';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if ($result === FALSE) 
        {
            $result['status'] = 0;
            $result['message'] = curl_error($ch);
        }

        curl_close($ch);

        $results = json_decode($result);

        $near_earth_objects = $results->near_earth_objects;

        $speed = [];
        $dis = [];
        $dates = [];

        foreach ($near_earth_objects as $key => $i) 
        {
            $dates[] = $key;

            $estimated_diameter = array_column($i, 'estimated_diameter');
            $kilometers = array_column($estimated_diameter, 'kilometers');
            $estimated_diameter_max = array_column($kilometers, 'estimated_diameter_max');
            $count = count($estimated_diameter_max);
            $avg_size = static::average($estimated_diameter_max, $count);


            $close_approach_data = array_column($i, 'close_approach_data');
            $kilometers_per_hour = [];
            $distance = [];
            foreach ($close_approach_data as $key) 
            {
                $relative_velocity = array_column($key, 'relative_velocity');
                $kilometers_per_hour[] = array_column($relative_velocity, 'kilometers_per_hour');


                $miss_distance = array_column($key, 'miss_distance');
                $distance[] = array_column($miss_distance, 'kilometers');
            };
            $speed[] = $kilometers_per_hour;
            $dis[] = $distance;         
        }
        $velocity = max(array_merge(...$speed));
        $max_speed = implode(" ",$velocity);

        $min_distance = min(array_merge(...$dis));
        $nearest = implode(" ",$min_distance);

        $dates = implode(',',$dates);

        return view('neo_feed_view')->with(array('avg_size'=>$avg_size, 'max_speed'=>$max_speed, 'nearest'=> $nearest, 'dates' => $dates));
    }


    #*************************************************************************
    # Find sum of array element
    #*************************************************************************
    function average( $a, $n)
    {
        $sum = 0;
        for ( $i = 0; $i < $n; $i++)
            $sum += $a[$i];
     
        return $sum / $n;
    }


}
