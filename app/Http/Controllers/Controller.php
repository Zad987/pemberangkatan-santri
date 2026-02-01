<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Success response JSON
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json(ApiResponse::success($data, $message, $statusCode));
    }

    /**
     * Error response JSON
     *
     * @param string $message
     * @param mixed $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'Error', $errors = null, int $statusCode = 400): JsonResponse
    {
        return response()->json(ApiResponse::error($message, $errors, $statusCode));
    }

    /**
     * Redirect with success message
     *
     * @param string $route
     * @param string $message
     * @param mixed $routeParams
     * @return RedirectResponse
     */
    protected function successRedirect(string $route, string $message = 'Operation successful', $routeParams = null): RedirectResponse
    {
        if ($routeParams) {
            return redirect()->route($route, $routeParams)->with('success', $message);
        }
        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Redirect back with error message
     *
     * @param string $message
     * @param array $errors
     * @return RedirectResponse
     */
    protected function errorBackRedirect(string $message = 'Operation failed', array $errors = []): RedirectResponse
    {
        return redirect()->back()
            ->withInput()
            ->with('error', $message)
            ->withErrors($errors);
    }

    /**
     * Format pagination response
     *
     * @param mixed $data
     * @param string $message
     * @return array
     */
    protected function paginatedResponse($data, string $message = 'Data retrieved successfully'): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ];
    }

    /**
     * Log user action
     *
     * @param string $action
     * @param string $description
     * @param string $model
     * @param int|null $modelId
     * @return void
     */
    protected function logAction(string $action, string $description, string $model = '', ?int $modelId = null): void
    {
        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 0,
                'action' => $action,
                'description' => $description,
                'model' => $model,
                'model_id' => $modelId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to log action', [
                'action' => $action,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Check if user has permission
     *
     * @param string $permission
     * @return bool
     */
    protected function hasPermission(string $permission): bool
    {
        $user = auth()->user();
        /** @var \App\Models\User|null $user */
        if (!$user) {
            return false;
        }

        // Map permissions to roles
        $permissions = [
            'view_dashboard' => ['induk', 'daerah', 'umum'],
            'manage_users' => ['induk'],
            'manage_categories' => ['induk'],
            'manage_regions' => ['induk'],
            'manage_participants' => ['induk', 'daerah'],
            'manage_payments' => ['induk', 'daerah'],
            'view_reports' => ['induk', 'daerah'],
            'manage_settings' => ['induk'],
        ];

        // Get the role value (handle enum)
        $roleValue = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;

        return isset($permissions[$permission]) && in_array($roleValue, $permissions[$permission]);
    }

    /**
     * Clear dashboard caches for affected regions
     *
     * @param int|null $regionId Specific region ID, or null to clear all relevant caches
     * @return void
     */
    protected function clearDashboardCaches(?int $regionId = null): void
    {
        try {
            $user = auth()->user();

            // Clear admin dashboard cache
            if ($user && $user->isAdmin()) {
                \Illuminate\Support\Facades\Cache::forget('admin_dashboard_' . $user->id);
            }

            // Clear regional dashboard cache
            if ($regionId) {
                \Illuminate\Support\Facades\Cache::forget('daerah_dashboard_' . $regionId);
            } elseif ($user && $user->region_id) {
                \Illuminate\Support\Facades\Cache::forget('daerah_dashboard_' . $user->region_id);
            }

            // Clear visitor dashboard cache
            \Illuminate\Support\Facades\Cache::forget('visitor_dashboard');

            // Clear keseluruhan participants cache
            \Illuminate\Support\Facades\Cache::forget('keseluruhan_participants');

        } catch (\Exception $e) {
            // Log but don't fail the operation
            \Illuminate\Support\Facades\Log::warning('Failed to clear dashboard caches', [
                'error' => $e->getMessage(),
                'region_id' => $regionId,
                'user_id' => $user ? $user->id : null
            ]);
        }
    }
}
