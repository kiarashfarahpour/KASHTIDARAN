<?php


namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Commercial;

class PendingCommercialsComposer
{
    public function compose(View $view)
    {
        $pendingCommercials         = Commercial::with('user')->pending()->take(4)->get();
        $pendingCommercialsCount    = Commercial::pending()->count();
        $view->with('pending_commercials', $pendingCommercials);
        $view->with('pending_commercials_count', $pendingCommercialsCount);
    }
}