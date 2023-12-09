<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAgreement
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is agreed
        if (auth()->check() && auth()->user()->isAgreed) {
            return $next($request);
        }

        abort(Response::HTTP_NOT_FOUND);
    }
}
