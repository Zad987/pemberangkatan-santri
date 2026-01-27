<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditTrailService
{
    /**
     * Log a user action
     */
    public static function log(
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        string $severity = 'info'
    ): void {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'severity' => $severity
        ]);
    }

    /**
     * Log user login
     */
    public static function logLogin(?string $description = null): void
    {
        self::log('LOGIN', null, null, null, null, $description, 'info');
    }

    /**
     * Log user logout
     */
    public static function logLogout(?string $description = null): void
    {
        self::log('LOGOUT', null, null, null, null, $description, 'info');
    }

    /**
     * Log model creation
     */
    public static function logCreation(string $modelType, int $modelId, array $values, ?string $description = null): void
    {
        self::log('CREATE', $modelType, $modelId, null, $values, $description, 'info');
    }

    /**
     * Log model update
     */
    public static function logUpdate(string $modelType, int $modelId, array $oldValues, array $newValues, ?string $description = null): void
    {
        self::log('UPDATE', $modelType, $modelId, $oldValues, $newValues, $description, 'warning');
    }

    /**
     * Log model deletion
     */
    public static function logDeletion(string $modelType, int $modelId, array $oldValues, ?string $description = null): void
    {
        self::log('DELETE', $modelType, $modelId, $oldValues, null, $description, 'danger');
    }

    /**
     * Log data export
     */
    public static function logExport(string $exportType, ?string $description = null): void
    {
        self::log('EXPORT', null, null, null, null, $description, 'info');
    }

    /**
     * Log data import
     */
    public static function logImport(string $importType, int $recordCount, ?string $description = null): void
    {
        $desc = $description ?? "Imported {$recordCount} records of type {$importType}";
        self::log('IMPORT', null, null, null, null, $desc, 'info');
    }

    /**
     * Log security event
     */
    public static function logSecurityEvent(string $eventType, array $details = [], ?string $description = null): void
    {
        $desc = $description ?? "Security event: {$eventType}";
        self::log($eventType, null, null, null, $details, $desc, 'danger');
    }

    /**
     * Get recent audit logs
     */
    public static function getRecentLogs(int $hours = 24, int $limit = 100)
    {
        return AuditLog::recent($hours)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get logs by user
     */
    public static function getUserLogs(int $userId, int $limit = 50)
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get logs by model
     */
    public static function getModelLogs(string $modelType, int $modelId, int $limit = 50)
    {
        return AuditLog::forModel($modelType, $modelId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get security-related logs
     */
    public static function getSecurityLogs(int $hours = 168) // Last 7 days
    {
        return AuditLog::recent($hours)
            ->whereIn('action', ['LOGIN', 'LOGOUT', 'DELETE'])
            ->orWhere('severity', 'danger')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}