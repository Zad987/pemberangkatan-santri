<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $startTime;

        // Only log POST, PUT, DELETE, PATCH requests
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $this->logAction($request, $response, $duration);
        }

        return $response;
    }

    /**
     * Log the action
     *
     * @param Request $request
     * @param mixed $response
     * @param float $duration
     * @return void
     */
    private function logAction(Request $request, $response, float $duration): void
    {
        try {
            if (!Auth::check()) {
                return;
            }

            $user = auth()->user();
            /** @var \App\Models\User|null $user */
            
            $logData = [
                'user_id' => $user?->id ?? 0,
                'action' => $request->method(),
                'description' => $this->getDescription($request),
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent(), 0, 255),
                'url' => substr($request->path(), 0, 255),
                'duration_ms' => round($duration * 1000, 2),
                'status_code' => $response->status(),
                'method' => $request->method(),
            ];

            // Extract model and ID from route if possible
            if ($request->route()) {
                $parameters = $request->route()->parameters();
                if (isset($parameters['id'])) {
                    $logData['model_id'] = $parameters['id'];
                }
            }

            \App\Models\AuditLog::create($logData);
        } catch (\Exception $e) {
            Log::warning('Failed to create audit log', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get description of the action
     *
     * @param Request $request
     * @return string
     */
    private function getDescription(Request $request): string
    {
        $method = $request->method();
        $path = $request->path();

        if ($method === 'POST') {
            if (strpos($path, 'user') !== false) return 'Menambah user baru';
            if (strpos($path, 'peserta') !== false) return 'Menambah peserta baru';
            if (strpos($path, 'kategori') !== false) return 'Menambah kategori baru';
            if (strpos($path, 'daerah') !== false) return 'Menambah daerah baru';
            return 'Membuat data baru';
        } elseif ($method === 'PUT') {
            if (strpos($path, 'user') !== false) return 'Memperbarui data user';
            if (strpos($path, 'peserta') !== false) return 'Memperbarui data peserta';
            if (strpos($path, 'kategori') !== false) return 'Memperbarui data kategori';
            if (strpos($path, 'daerah') !== false) return 'Memperbarui data daerah';
            return 'Memperbarui data';
        } elseif ($method === 'DELETE') {
            if (strpos($path, 'user') !== false) return 'Menghapus user';
            if (strpos($path, 'peserta') !== false) return 'Menghapus peserta';
            if (strpos($path, 'kategori') !== false) return 'Menghapus kategori';
            if (strpos($path, 'daerah') !== false) return 'Menghapus daerah';
            return 'Menghapus data';
        }

        return 'Melakukan aksi';
    }
}
