<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Province;
use App\Models\Commercial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings               = get_settings();
        $cities                 = City::latest('sort_order')->get();
        $provinces              = Province::latest()->get();
        $categories             = Category::with('image', 'children')->main()->published()->get();
        $latestCommercials      = Commercial::with('city', 'district', 'category.image')->accepted()->latest()->take(9)->get();
        $expertisedCommercials  = Commercial::with('city', 'district', 'category.image')->expertised()->accepted()->latest()->take(9)->get();
        $immediateCommercials   = Commercial::with('city', 'district', 'category.image')->immediated()->accepted()->latest()->take(9)->get();
        $featuredCategories     = Category::with('activeChildren')->featured()->get();
        foreach($featuredCategories as $fc) {
            $featuredCategoriesIds = [];
            $featuredCategoriesIds[] = $fc->id;
            foreach($fc->activeChildren as $child) {
                $featuredCategoriesIds[] = $child->id;
            }
            $fCommercials   = Commercial::with('category.image')->whereIn('category_id', $featuredCategoriesIds)->accepted()->latest()->take(6)->get();
            $fc->setRelation('commercials', $fCommercials);
        }
        /*$featuredCategories     = Category::with(['commercials' => function($query) {
            $query->with('category.image')->accepted();
        }])->featured()->get()->map(function($category) {
             $category->setRelation('commercials', $category->commercials->reverse()->take(6));
             return $category;
        });*/
        $aboveFooter    = Banner::with('orderedItems.image')->inPosition('above-footer')->first();
        return view('frontend.app.index', compact('settings', 'cities', 'categories', 'latestCommercials', 'provinces', 'featuredCategories', 'expertisedCommercials', 'immediateCommercials', 'aboveFooter'));
    }
}
