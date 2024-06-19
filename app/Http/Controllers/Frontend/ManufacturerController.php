<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Product;

class ManufacturerController extends Controller
{
    /**
     * Show the specified resource.
     * @param Manufacturer $manufacturer
     * @return Response
     */
    public function show(Manufacturer $manufacturer)
    {
        $products   = Product::where('manufacturer_id', $manufacturer->id)->latest()->paginate();
        return view('frontend.manufacturers.show', compact('manufacturer', 'products'));
    }
}
