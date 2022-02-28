<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNurse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //todo: its need to discuss
//        if(auth()->user()->is_admin){
//            return $next($request);
//        }

        if(auth()->user()->is_nurse){
            return $next($request);
        }

        return redirect('404');
    }
}
