<?php


namespace App\Http\ViewComposers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Contracts\View\View;

class CitiesComposer
{
    public function compose(View $view)
    {
        $cities     = City::latest('sort_order')->get();
        $provinces  = Province::latest()->get();
        $view->with('cities', $cities);
        $view->with('provinces', $provinces);
    }
}