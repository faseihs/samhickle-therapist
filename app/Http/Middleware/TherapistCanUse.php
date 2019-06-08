<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TherapistCanUse
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
        if($th=Auth::user()){
            if(Auth::guard('therapist')->check()){
                if($th->canUse())
                    return $next($request);
                else return redirect('/plans')->with('success','You need to chose a plan to continue using the platform');
            }
            else return redirect('/');
        }
        else return redirect('/');

    }
}
