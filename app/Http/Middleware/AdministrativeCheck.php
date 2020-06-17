<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdministrativeCheck
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::user()->isAdministrativeUser()) {
            return $next($request);
        }

        return response()->json([
            'error_code' => 403,
            'error_message' => 'You do not have proper access rights.'
        ], 403);
    }
}
