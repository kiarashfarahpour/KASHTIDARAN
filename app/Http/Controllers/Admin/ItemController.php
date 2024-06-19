<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Models\Image;
use App\Models\Weather;
use App\Models\WeatherItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ItemController extends Controller
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
     * @param  \App\Models\Weather  $weather
     * @return Response
     */
    public function index(Weather $weather)
    {
        $items = WeatherItem::where('weather_id', $weather->id)->latest()->paginate();
        return view('admin.items.index', compact('weather', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Models\Weather  $weather
     * @return Response
     */
    public function create(Weather $weather)
    {
        return view('admin.items.create', compact('weather'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Weather  $weather
     * @return Response
     */
    public function store(ItemRequest $request, Weather $weather)
    {
        $item_data = [
            'title'             => $request->input('title'),
            'file'              => $request->input('file'),
            'link'              => $request->input('link'),
            'suffix'            => $request->input('suffix'),
            'method'            => $request->input('method'),
            'element'           => $request->input('element'),
            'duration'          => $request->input('duration'),
            'site'              => $request->input('site'),
            'last_link'         => $request->input('last_link'),
            'last_link_element' => $request->input('last_link_element'),
            'content'           => $request->input('content'),
            'image_id'          => $request->input('image_id'),
            'sort_order'        => $request->input('sort_order'),
        ];
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/weather/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/weather/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                $item_data['image_id'] = $image->id;
            }
        }
        $weather->items()->create($item_data);
        $this->doneMessage('آیتم با موفقیت آپدیت شد.');
        return back();
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
     * @param  \App\Models\WeatherItem  $item
     * @return Response
     */
    public function edit(WeatherItem $item)
    {
        $item->load('image', 'weather');
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WeatherRequest  $request
     * @param  \App\Models\WeatherItem  $item
     * @return Response
     */
    public function update(ItemRequest $request, WeatherItem $item)
    {
        $item_data = [
            'title'             => $request->input('title'),
            'file'              => $request->input('file'),
            'link'              => $request->input('link'),
            'suffix'            => $request->input('suffix'),
            'method'            => $request->input('method'),
            'element'           => $request->input('element'),
            'duration'          => $request->input('duration'),
            'site'              => $request->input('site'),
            'last_link'         => $request->input('last_link'),
            'last_link_element' => $request->input('last_link_element'),
            'content'           => $request->input('content'),
            'image_id'          => $request->input('image_id'),
            'sort_order'        => $request->input('sort_order'),
        ];
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/weather/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/weather/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                $item_data['image_id'] = $image->id;
            }
        }
        $item->update($item_data);
        $this->doneMessage("با موفقیت آپدیت شد.");
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
