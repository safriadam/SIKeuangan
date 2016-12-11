<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Routing\Middleware;


class cekStatus
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
        $status  = $request->user()->status;
        

        if ($status != 'AKTIF'){

            return redirect('forbidden');
        }
        return $next($request);
    }
}
