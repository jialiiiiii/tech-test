<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        if ($to > $from) {
            // echo "asc";
        } else {
            // echo "desc";
        }

        $path = resource_path() . '/data/mrt.json';
        $mrt_json = json_decode(file_get_contents($path));

        $path = resource_path() . '/data/fare.json';
        $fare_json = json_decode(file_get_contents($path));

        // Get accumulated distance
        $distance = 0;
        $isFrom = false;
        $isTo = false;

        foreach ($mrt_json as $mrt) {
            $code_now = '';

            foreach ($mrt->codes as $y) {
                if ($y == $from) {
                    $isFrom = true;
                }
                if ($y == $to) {
                    $isTo = true;
                    $code_now = $y;
                }
            }

            // Ascending order, e.g. TE1 to TE3
            if ($to > $from && $isTo) {
                break;
            }
            if ($isFrom && $to > $from && $mrt->next_distance) {
                $distance += $mrt->next_distance;
            }

            // Descending order, e.g. TE5 to TE3
            if ($isTo && $to < $from && $mrt->previous_distance && $code_now != $to) {
                $distance += $mrt->previous_distance;
            }
            if ($to < $from && $isFrom) {
                break;
            }
        }
 
        if (!$isFrom || !$isTo) {
            $distance = '';
        } else {
            // echo 'Distance is ' . $distance;
        }

        // Get fare using distance
        $fare = 0;

        foreach ($fare_json as $f) {
            if ($f->from <= $distance && $f->to >= $distance) {
                $fare = $f->fare;
            }
        }

        if (!$isFrom || !$isTo) {
            $fare = '';
        } else {
            // echo 'Fare is ' . $fare;
        }

        // Get list of stations
        $stations = [];
        foreach ($mrt_json as $x) {
            foreach ($x->codes as $y) {
                $stations[] = $y;
            }
        }

        return view('test', compact('stations', 'distance', 'fare'));
    }
}
