<?php

namespace App\Http\ViewComposers;

use App\Models\Country;
use Cache;
use Illuminate\View\View;

class CountriesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $countries = Cache::remember('countries-select', 10080, function () {
            return Country::orderBy('name')->lists('name', 'id');
        });

        $view->with(['countries' => $countries]);
    }
}