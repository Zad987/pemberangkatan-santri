<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $limit
     * @param  int  $window
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $limit = 60, int $window = 60)
    {
        $key = 'rate_limit:' . $request->ip() . ':' . $request->path();
        $current = \Illuminate\Support\Facades\Cache::get($key, 0);

        if ($current >= $limit) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Silakan coba lagi dalam beberapa saat.',
            ], 429);
        }

        \Illuminate\Support\Facades\Cache::put($key, $current + 1, $window);

        return $next($request);
    }
}
