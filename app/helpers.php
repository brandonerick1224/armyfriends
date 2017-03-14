<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

if (! function_exists('get_locale')) {
    /**
     * Set application locale
     *
     * @return string
     */
    function get_locale()
    {
        return App::getLocale();
    }
}

if (! function_exists('set_locale')) {
    /**
     * Set application locale
     *
     * @param  string|null  $locale
     */
    function set_locale($locale)
    {
        App::setLocale($locale);
        Carbon\Carbon::setLocale($locale);
    }
}

if (! function_exists('array_diff_multi')) {
    /**
     * Compare two array by keys multidimensional
     *
     * @param $array1
     * @param $array2
     * @return array
     */
    function array_diff_multi($array1, $array2)
    {
        $result = [];
        foreach ($array1 as $key => $val) {
            if (isset($array2[$key])) {
                if (is_array($val) && $array2[$key]) {
                    $diff = array_diff_multi($val, $array2[$key]);
                    if ($diff) {
                        $result[$key] = $diff;
                    }
                }
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }
}

if (! function_exists('api_response')) {
    /**
     * Return a new api_response from the application.
     *
     * @param $data
     * @return ApiResponse
     */
    function api_response($data = null)
    {
        if (null === $data) {
            $data = 'Success';
        }
        return new ApiResponse($data);
    }
}
