<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WeatherRequest;
use App\Models\Image;
use App\Models\Weather;
use App\Models\WeatherItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WeatherController extends Controller
{
    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:weather-manage');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $weather = Weather::latest()->paginate();
        return view('admin.weather.index', compact('weather'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * This action saves a banner and its items into the database.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Weather  $weather
     * @return Response
     */
    public function edit(Weather $weather)
    {
        
        return view('admin.weather.edit', compact('weather'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WeatherRequest  $request
     * @param  \App\Models\Weather  $weather
     * @return Response
     */
    public function update(Request $request,Weather $weather)
    {
        //WeatherRequest $request

        $weather_item = $request->only(['name', 'slug']);
                      
        $weather_item['status'] = $request->input('status') ? Weather::STATUS_PUBLISHED : Weather::STATUS_DRAFT;

        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/weather/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/weather/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
              
                $weather_item['image_id'] = $image->id;
            }
        }
        $weather->update($weather_item);
        $this->doneMessage("استان $weather->name آپدیت شد.");
        return redirect()->route('admin.weather.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return Response
     */
    public function destroy($id)
    {
       //
    }
}
