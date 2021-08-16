<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MyLogin
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
        if( $request->session()->has('idUser') && $request->session()->has('loginUser') && $request->session()->has('passwordUser'))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('mylogin');
        }

    }
}
