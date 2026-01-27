<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'status',
        'amount',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'status' => PaymentStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    // Scopes
    public function scopeLunas($query)
    {
        return $query->where('status', PaymentStatus::LUNAS);
    }

    public function scopeBelum($query)
    {
        return $query->where('status', PaymentStatus::BELUM);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('notes', 'LIKE', "%{$term}%");
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }

    // Methods
    public function markAsPaid()
    {
        $this->update(['status' => PaymentStatus::LUNAS]);
    }

    public function markAsUnpaid()
    {
        $this->update(['status' => PaymentStatus::BELUM]);
    }
}
