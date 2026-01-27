<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

/**
 * API Response Helper
 */
class ApiResponse
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return array
     */
    public static function success($data = null, string $message = 'Success', int $code = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Error response
     *
     * @param string $message
     * @param mixed $errors
     * @param int $code
     * @return array
     */
    public static function error(string $message = 'Error', $errors = null, int $code = 400): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $code,
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Paginated response
     *
     * @param mixed $data
     * @param string $message
     * @return array
     */
    public static function paginated($data, string $message = 'Data retrieved successfully'): array
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
            ],
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Created response
     *
     * @param mixed $data
     * @param string $message
     * @return array
     */
    public static function created($data, string $message = 'Resource created successfully'): array
    {
        return self::success($data, $message, 201);
    }

    /**
     * Validation error response
     *
     * @param array $errors
     * @param string $message
     * @return array
     */
    public static function validationError(array $errors, string $message = 'Validation failed'): array
    {
        return self::error($message, $errors, 422);
    }

    /**
     * Not found response
     *
     * @param string $message
     * @return array
     */
    public static function notFound(string $message = 'Resource not found'): array
    {
        return self::error($message, null, 404);
    }

    /**
     * Unauthorized response
     *
     * @param string $message
     * @return array
     */
    public static function unauthorized(string $message = 'Unauthorized'): array
    {
        return self::error($message, null, 401);
    }

    /**
     * Forbidden response
     *
     * @param string $message
     * @return array
     */
    public static function forbidden(string $message = 'Forbidden'): array
    {
        return self::error($message, null, 403);
    }
}
