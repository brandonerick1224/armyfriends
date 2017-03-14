<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Auth;
use Illuminate\Contracts\Validation\UnauthorizedException;

class Authenticate
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
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                throw new UnauthorizedException;
            } else {
                return redirect()->guest('login');
            }
        }

        // Update default guard based on middleware param
        if ($guard) {
            config(['auth.defaults.guard' => $guard]);
        }

        Auth::guard($guard)->user()->update(['last_online' => Carbon::now()]);

        return $next($request);
    }
}
