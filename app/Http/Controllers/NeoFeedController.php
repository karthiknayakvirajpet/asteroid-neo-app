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

        $a = json_decode($result);

        $b = $a->near_earth_objects;

        foreach ($b as $key => $i) 
        {
            //return gettype($b);

            $z = array_column($i, 'id');
            return $z;
        }


       


        //return view('neo_feed_view')->with(array($this->discountdetail_=>$discountdetail));
    }


}
