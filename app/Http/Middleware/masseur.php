<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class masseur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role==0){
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
