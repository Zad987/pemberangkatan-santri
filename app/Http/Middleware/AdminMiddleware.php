<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login');
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Check if user is admin using the improved method
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
