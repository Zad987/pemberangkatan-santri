<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'province',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class, 'region_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'region_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('code', 'LIKE', "%{$term}%")
                    ->orWhere('province', 'LIKE', "%{$term}%");
    }

    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    // Accessors
    public function getParticipantCountAttribute()
    {
        return $this->participants()->count();
    }

    public function getPaidParticipantCountAttribute()
    {
        return $this->participants()->paid()->count();
    }

    public function getUnpaidParticipantCountAttribute()
    {
        return $this->participants()->unpaid()->count();
    }

    public function getPaymentRateAttribute()
    {
        $total = $this->participant_count;
        if ($total === 0) return 0;
        return round(($this->paid_participant_count / $total) * 100, 2);
    }

    public function getTotalRevenueAttribute()
    {
        return $this->participants()
            ->whereHas('payments', function($q) {
                $q->where('status', 'lunas');
            })
            ->join('categories', 'participants.category_id', '=', 'categories.id')
            ->whereNull('participants.deleted_at') // Ensure we don't include soft deleted participants
            ->whereNull('categories.deleted_at') // Ensure we don't include soft deleted categories
            ->sum('categories.price');
    }

    // Methods
    public function isActive()
    {
        return $this->is_active === true;
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function getStats()
    {
        return [
            'total_participants' => $this->participant_count,
            'paid_participants' => $this->paid_participant_count,
            'unpaid_participants' => $this->unpaid_participant_count,
            'payment_rate' => $this->payment_rate,
            'total_revenue' => $this->total_revenue,
        ];
    }
}
