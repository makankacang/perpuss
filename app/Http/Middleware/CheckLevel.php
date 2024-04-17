<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLevel
{
    public function handle(Request $request, Closure $next, $level)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the user's level
            $userLevel = Auth::user()->level;

            // Check if the user's level matches the specified level
            if ($userLevel == $level) {
                return $next($request);
            }
        }

        // If the user's level does not match, redirect back
        return redirect('/');
    }
}
