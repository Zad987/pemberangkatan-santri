<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'region_id',
        'category_id',
        'phone',
        'email',
        'address',
        'birth_date',
        'gender',
        'created_by'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->whereHas('payments', function ($q) {
            $q->where('status', PaymentStatus::LUNAS);
        });
    }

    public function scopeUnpaid($query)
    {
        return $query->whereDoesntHave('payments', function ($q) {
            $q->where('status', PaymentStatus::LUNAS);
        });
    }

    public function scopeByRegion($query, $regionId)
    {
        return $query->where('region_id', $regionId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('phone', 'LIKE', "%{$term}%")
                    ->orWhere('email', 'LIKE', "%{$term}%");
    }

    // Accessors
    public function getPaymentStatusAttribute()
    {
        $categoryPrice = (float) ($this->category->price ?? 0);
        $totalPaid = (float) $this->payments->sum('amount');
        
        // If category has no price, consider as paid if any payment exists
        if ($categoryPrice == 0) {
            return $this->payments->isNotEmpty() ? PaymentStatus::LUNAS->value : PaymentStatus::BELUM->value;
        }
        
        // For categories with price, check if total paid meets or exceeds the price
        return ($totalPaid >= $categoryPrice) ? PaymentStatus::LUNAS->value : PaymentStatus::BELUM->value;
    }

    public function getRemainingBalanceAttribute()
    {
        $categoryPrice = (float) ($this->category->price ?? 0);
        $totalPaid = (float) $this->payments->sum('amount');
        return max(0, $categoryPrice - $totalPaid);
    }

    public function getIsPaidAttribute()
    {
        return $this->payment_status === PaymentStatus::LUNAS->value;
    }

    public function getTotalPaidAttribute()
    {
        return (float) $this->payments->sum('amount');
    }

    // Methods
    public function markAsPaid($amount = null, $notes = null)
    {
        $categoryPrice = $this->category ? $this->category->price : 0;
        $paymentAmount = $amount ?: $categoryPrice;

        return $this->payments()->create([
            'amount' => $paymentAmount,
            'status' => PaymentStatus::LUNAS,
            'notes' => $notes,
            'paid_at' => now(),
        ]);
    }

    public function markAsUnpaid()
    {
        return $this->payments()->create([
            'amount' => 0,
            'status' => PaymentStatus::BELUM,
            'notes' => 'Ditandai sebagai belum bayar',
            'paid_at' => null,
        ]);
    }
}
