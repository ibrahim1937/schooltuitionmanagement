<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Route;
use Auth;

class AuthenticatedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Route::is('loginpage') || Route::is('forgetpasswordpage') || Route::is('resetpassword')){
                return redirect()->back();
            }
            return $next($request);
        }
        return $next($request);
    }
}
