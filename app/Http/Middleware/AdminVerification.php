<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');
        // Check if user is logged in and has login_type 2
        if (!$user || $user->login_type != 1) {
            return redirect('/admin-login')->withErrors(['message' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
