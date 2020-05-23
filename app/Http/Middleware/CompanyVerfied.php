<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CompanyVerfied
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'company')
    {
        if (Auth::guard($guard)->user()->email_verified_at =='') {
            return redirect('/needToActive');
        }

        return $next($request);
    }
}
