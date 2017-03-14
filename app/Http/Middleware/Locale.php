<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Response;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $lang = $request->cookie('lang');
        $langs = array_keys(config('laravellocalization.supportedLocales'));

        $addCookie = false;
        if (! in_array($lang, $langs)) {
            $addCookie = true;
            $lang = $request->getPreferredLanguage($langs);
        }

        set_locale($lang);

        /** @var Response $response */
        $response = $next($request);

        if ($addCookie) {
            $response->cookie(\Cookie::forever('lang', $lang));
        }

        /** @var User $user */
        $user = auth()->user();

        // Update user's locale if user is logged in
        if ($user && $user->locale !== $lang) {
            $user->update(['locale' => $lang]);
        }

        return $response;
    }
}
