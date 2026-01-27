<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $limiter = 'api'): Response
    {
        // Skip rate limiting for admins
        $user = $request->user();
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        $key = $this->resolveRequestSignature($request);
        $maxAttempts = $this->getMaxAttempts($limiter);
        $decayMinutes = $this->getDecayMinutes($limiter);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            return response()->json([
                'error' => 'Too Many Requests',
                'message' => "Too many requests. Please try again in {$seconds} seconds.",
                'retry_after' => $seconds
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        $response = $next($request);

        return $response;
    }

    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        if ($user = $request->user()) {
            return sha1($user->getAuthIdentifier());
        }

        return sha1($request->ip() . '|' . $request->header('User-Agent'));
    }

    /**
     * Get max attempts based on limiter type.
     */
    protected function getMaxAttempts(string $limiter): int
    {
        return match($limiter) {
            'login' => 5,           // 5 attempts per hour
            'api' => 60,            // 60 requests per minute
            'payment' => 20,        // 20 payment requests per minute
            'export' => 10,         // 10 exports per hour
            default => 60,
        };
    }

    /**
     * Get decay minutes based on limiter type.
     */
    protected function getDecayMinutes(string $limiter): int
    {
        return match($limiter) {
            'login' => 60,          // 1 hour
            'api' => 1,             // 1 minute
            'payment' => 1,         // 1 minute
            'export' => 60,         // 1 hour
            default => 1,
        };
    }
}