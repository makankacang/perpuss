<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class CheckLevelMiddleware
{
    public function handle($request, Closure $next, ...$levels)
    {
        // Check if the user is authenticated and their level matches any of the expected levels
        if (Auth::check() && in_array(Auth::user()->level, $levels)) {
            // If the user's level matches, proceed with the request
            return $next($request);
        }

        // Customize the error message and redirection
        $message = 'Unauthorized access. You will be redirected in 5 seconds.';
        $redirectPath = '/unauthorized'; // Route for unauthorized access

        // Return a response with the error message and redirection
        return new Response(view('errors.unauthorized', compact('message', 'redirectPath')));
    }
}
