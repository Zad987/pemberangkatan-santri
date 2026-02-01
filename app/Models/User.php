<?php

namespace App\Models;

use App\Enums\UserRole;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'region_id',
        'phone',
        'last_login_at',
        'last_login_ip',
        'is_active',
        'current_session_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'role' => UserRole::class,
    ];

    // Relationships
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'region_id', 'region_id');
    }

    public function createdParticipants()
    {
        return $this->hasMany(Participant::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', UserRole::INDUK);
    }

    public function scopeDaerah($query)
    {
        return $query->where('role', UserRole::DAERAH);
    }

    public function scopeUmum($query)
    {
        return $query->where('role', UserRole::UMUM);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('username', 'LIKE', "%{$term}%");
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getRoleLabelAttribute()
    {
        return match($this->role) {
            UserRole::INDUK => UserRole::INDUK->label(),
            UserRole::DAERAH => UserRole::DAERAH->label(),
            UserRole::UMUM => UserRole::UMUM->label(),
            default => ucfirst($this->role)
        };
    }

    // Methods
    public function isAdmin()
    {
        // Handle both direct enum comparison and string comparison
        if ($this->role instanceof UserRole) {
            return $this->role->value === 'induk';
        }
        // Convert string to lowercase to handle any case variations
        $roleValue = is_string($this->role) ? strtolower($this->role) : $this->role;
        return $roleValue === 'induk' || $roleValue === 'INDUK' || $this->role === UserRole::INDUK;
    }

    public function isDaerah()
    {
        // Handle both direct enum comparison and string comparison
        if ($this->role instanceof UserRole) {
            return $this->role->value === 'daerah';
        }
        // Convert string to lowercase to handle any case variations
        $roleValue = is_string($this->role) ? strtolower($this->role) : $this->role;
        return $roleValue === 'daerah' || $roleValue === 'DAERAH' || $this->role === UserRole::DAERAH;
    }

    public function isUmum()
    {
        // Handle both direct enum comparison and string comparison
        if ($this->role instanceof UserRole) {
            return $this->role->value === 'umum';
        }
        // Convert string to lowercase to handle any case variations
        $roleValue = is_string($this->role) ? strtolower($this->role) : $this->role;
        return $roleValue === 'umum' || $roleValue === 'UMUM' || $this->role === UserRole::UMUM;
    }

    public function getRoleAttribute($value)
    {
        // Ensure proper enum handling
        if (empty($value)) {
            return null;
        }
        
        // If it's already an enum instance, return it
        if ($value instanceof UserRole) {
            return $value;
        }
        
        // If it's a string, try to convert to enum
        try {
            return UserRole::from($value);
        } catch (\ValueError $e) {
            // If conversion fails, return the raw value
            return $value;
        }
    }

    public function isActive()
    {
        return $this->is_active === true;
    }

    public function updateLastLogin()
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }
}
