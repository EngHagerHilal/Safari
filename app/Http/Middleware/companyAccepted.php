<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class companyAccepted
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
        if (Auth::guard($guard)->user()->status =='pending') {
            return response( view('company.account_pending'));
        }
        elseif(Auth::guard($guard)->user()->status =='rejected'){
            return response( view('company.account_rejected'));
        }
        elseif(Auth::guard($guard)->user()->status =='blocked'){
            return response( view('company.account_blocked'));
        }

        return $next($request);
    }
}
