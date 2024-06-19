<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
    {
        $products = Product::where('status', 1)->latest('stock')->paginate(16);
        return view('frontend.products.index',compact('products'));
    }

    /**
     * Show the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        $product->load('attributes', 'attributes.group', 'options', 'options.option', 'options.optionValues');
        abort_unless($product->status, 404);
        $product->increment('view_counts');
        $attributes = [];
        $highlightAttributes = [];
        foreach ($product->attributes as $attribute)
        {
            $attributes[$attribute->group->id]['group'] = $attribute->group->name;
            $attributes[$attribute->group->id]['attributes'][$attribute->name] = $attribute->pivot->value;
            $attributes[$attribute->group->id]['attrs_desc'][$attribute->name] = $attribute->sort_order;
            if ($attribute->pivot->highlight)
            {
                $highlightAttributes[$attribute->name] = $attribute->pivot->value;
            }
        }
        $highlightAttributes = collect($highlightAttributes);

        // Separate highlight attributes in two variables
        $half   = ceil($highlightAttributes->count() / 2);
        $showAttributes = [];
        $hideAttributes = [];
        if($half > 0) {
            if($highlightAttributes->count() == 1)
            {
                $showAttributes = $highlightAttributes;
            }
            else {
                list(
                    $showAttributes,
                    $hideAttributes
                    )   = $highlightAttributes->chunk($half);
            }
        }

        if (!is_null($product->special)) {
            $product->discount    = number_format(100 - $product->special * 100 / $product->price);
            $product->special     = number_format($product->special, 0, '.', ',');
            $product->remained    = $product->special_ended_at - $product->special_started_at;
        }

        $product->excerpt   = substr($product->description, 0, 500);

        $relatedProducts    = Product::whereHas('categories', function($query) use($product)
        {
            $query->whereIn('id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)->inRandomOrder()->distinct()->take(3)->get();

        $suggestedProducts  = Product::getSuggests();

        $productCategories  = $product->categories;

        return view('frontend.products.show', compact('product', 'attributes', 'relatedProducts', 'highlightAttributes', 'showAttributes', 'hideAttributes', 'suggestedProducts', 'productCategories'));
    }
}
