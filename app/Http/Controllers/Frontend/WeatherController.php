<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Weather;
use App\Http\Controllers\Controller;

class WeatherController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weather = Weather::with('items')->published()->get();
        return view('frontend.weather.index', compact('weather'));
    }
    
    public function show(Weather $weather)
    {
        abort_unless($weather->status, 404);
        $weather->load('items');
        return view('frontend.weather.show', compact('weather'));
    }
}
