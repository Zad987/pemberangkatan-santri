<?php

namespace App\Models;

use App\Enums\AuditAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'description',
        'severity'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'action' => AuditAction::class,
    ];

    /**
     * Get the user that performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by action type
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for filtering by model
     */
    public function scopeForModel($query, $modelType, $modelId = null)
    {
        $query->where('model_type', $modelType);
        
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        
        return $query;
    }

    /**
     * Scope for filtering by severity
     */
    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Scope for recent logs
     */
    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    /**
     * Get human readable action description
     */
    public function getActionDescriptionAttribute()
    {
        if ($this->action instanceof AuditAction) {
            return $this->action->description();
        }
        
        // Fallback for string values
        $descriptions = [
            'CREATE' => 'Membuat data baru',
            'UPDATE' => 'Memperbarui data',
            'DELETE' => 'Menghapus data',
            'VIEW' => 'Melihat data',
            'LOGIN' => 'Masuk sistem',
            'LOGIN_FAILED' => 'Login gagal',
            'LOGIN_ERROR' => 'Error saat login',
            'LOGOUT' => 'Keluar sistem',
            'EXPORT' => 'Mengekspor data',
            'IMPORT' => 'Mengimpor data'
        ];

        return $descriptions[$this->action] ?? $this->action;
    }

    /**
     * Get formatted model information
     */
    public function getModelInfoAttribute()
    {
        if (!$this->model_type || !$this->model_id) {
            return 'System Action';
        }

        // Try to get the actual model instance
        try {
            $modelClass = '\\App\\Models\\' . str_replace('App\\Models\\', '', $this->model_type);
            if (class_exists($modelClass)) {
                $model = $modelClass::find($this->model_id);
                if ($model && isset($model->name)) {
                    return $model->name;
                }
            }
        } catch (\Exception $e) {
            // Silently fail if model can't be loaded
        }

        return "{$this->model_type} #{$this->model_id}";
    }
}
