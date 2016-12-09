<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Routing\Middleware;


class cekAdmin 
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
        if($request->user()->jabatan !='KETUA')
        {
            return redirect('/');
        }
        
        return $next($request);
    }
}
