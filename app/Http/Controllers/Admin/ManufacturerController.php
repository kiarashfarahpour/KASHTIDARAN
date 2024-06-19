<?php

namespace App\Http\Controllers\Admin;

use App\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Manufacturer;
use App\Models\Image;
use App\Http\Requests\ManufacturerRequest;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $manufacturers = Manufacturer::with('image')->latest()->paginate();
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.manufacturers.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\ManufacturerRequest  $request
     * @return Response
     */
    public function store(ManufacturerRequest $request)
    {
        $image_id = null;
        if($request->hasfile('image'))
        {
            $date   = date('Y/m');
            $image  = $request->file('image');
            $name   = Str::random(64);
            if($image->storeAs('public/images/manufacturers/' . $date, $name . '.' . $image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/manufacturers/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                ImageManager::resize($image->name, ['width' => 25, 'height' => 25]);
                ImageManager::resize($image->name, ['width' => 78, 'height' => 40]);
                ImageManager::resize($image->name, ['width' => 125, 'height' => 125]);
                ImageManager::resize($image->name, ['width' => 200, 'height' => 100]);
                $image_id = $image->id;
            }
        }
        $manufacturer = Manufacturer::create([
            'name'          => $request->input('name'),
            'slug'          => $request->input('slug'),
            'image_id'      => $image_id,
            'description'   => $request->input('description'),
        ]);
        $this->doneMessage("تولید کننده $manufacturer->name با موفقیت ایجاد گردید.");
        return redirect()->route('admin.manufacturers.index');
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
     * @param  \App\Models\Manufacturer  $manufacturer
     *
     * @return Response
     */
    public function edit(Manufacturer $manufacturer)
    {
        $manufacturer->load('image');
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\ManufacturerRequest  $request
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return Response
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $manufacturer_data = $request->only(['name', 'slug', 'description']);
        if($request->hasfile('image'))
        {
            $date   = date('Y/m');
            $image  = $request->file('image');
            $name   = Str::random(64);
            if($image->storeAs('public/images/manufacturers/' . $date, $name . '.' . $image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/manufacturers/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                ImageManager::resize($image->name, ['width' => 25, 'height' => 25]);
                ImageManager::resize($image->name, ['width' => 78, 'height' => 40]);
                ImageManager::resize($image->name, ['width' => 125, 'height' => 125]);
                ImageManager::resize($image->name, ['width' => 200, 'height' => 100]);
                $manufacturer_data['image_id'] = $image->id;
            }
        }
        elseif($request->input('remove-image'))
        {
            $manufacturer_data['image_id'] = null;
        }
        $manufacturer->update($manufacturer_data);
        $this->doneMessage("$manufacturer->name با موفقیت آپدیت شد.");
        return redirect()->route('admin.manufacturers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  integer  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $manufacturer = Manufacturer::findOrFail($id);
        if ( isset($data['delete'] ))
        {
            $manufacturer->delete();
        }
        $this->doneMessage();
        return redirect()->route('admin.manufacturers.index');
    }
}
