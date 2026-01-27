<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function participants()
    {
        return $this->hasMany(Participant::class, 'category_id');
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
                    ->orWhere('description', 'LIKE', "%{$term}%");
    }

    public function scopeAbovePrice($query, $price)
    {
        return $query->where('price', '>', $price);
    }

    public function scopeBelowPrice($query, $price)
    {
        return $query->where('price', '<', $price);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getParticipantCountAttribute()
    {
        return $this->participants()->count();
    }

    public function getTotalRevenueAttribute()
    {
        return $this->participants()->whereHas('payments', function($q) {
            $q->where('status', 'lunas');
        })->count() * $this->price;
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
}
