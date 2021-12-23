<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAreaGuard
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
            $user = Auth::user();
            if ($user->hasRole('administrator')){
                return $next($request);
            }else{
                if($user->can('admin area')){
                    return $next($request);
                }else{
                    return redirect(route('index'));
                }
            }
        }else{
            return redirect(route('admin-login'));
        }

    }
}
