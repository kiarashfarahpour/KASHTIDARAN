<?php


namespace App\Http\ViewComposers;

use App\Models\City;
use Illuminate\Contracts\View\View;
use Route;

class DistrictsComposer
{
    public function compose(View $view)
    {
        $routeParameters    = Route::current()->parameters;
        if(isset($routeParameters['city']) && $routeParameters['city'] != 'all') {
            $city               = City::with([
                'districts' => function ($query) {
                    $query->oldest('sort_order');
                }
            ])
                ->whereSlug($routeParameters['city'])
                ->first();
            $districts          = $city->districts;
        } else {
            $districts = collect([]);
        }
        $view->with('districts', $districts);
    }
}