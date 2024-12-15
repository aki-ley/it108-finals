<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $usertype
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $usertype)
    {
        // Check if the user is logged in and their type matches
        if (Auth::check() && Auth::user()->usertype === $usertype) {
            return $next($request);
        }

        // Redirect to home page or unauthorized page
        return redirect('/')->with('error', 'Unauthorized access!');
    }
}
