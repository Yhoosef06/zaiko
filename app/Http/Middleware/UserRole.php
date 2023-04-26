<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $account_type)
    {
        
        $account_type = explode('|', $account_type);
        if(Auth::check() && in_array(Auth::user()->account_type, $account_type)){
            return $next($request);
        }
        return response()->json(["You don't have permission to access this page"]);
    }
}
