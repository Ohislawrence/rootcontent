<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'payment_reference',
        'amount', 'status', 'paystack_response'
    ];

    protected $casts = [
        'paystack_response' => 'array',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return '₦' . number_format($this->amount, 2);
    }

    public function getFormattedStatusAttribute()
    {
        $statusColors = [
            'pending' => 'yellow',
            'successful' => 'green',
            'failed' => 'red',
            'cancelled' => 'gray',
        ];

        $color = $statusColors[$this->status] ?? 'gray';

        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-' . $color . '-100 text-' . $color . '-800">' . ucfirst($this->status) . '</span>';
    }

    public function getPaystackReferenceAttribute()
    {
        return $this->paystack_response['reference'] ?? 'N/A';
    }

    public function getPaymentMethodAttribute()
    {
        return $this->paystack_response['channel'] ?? 'N/A';
    }

    public function getPaymentDateAttribute()
    {
        return $this->paystack_response['paid_at'] ?? $this->created_at->format('Y-m-d H:i:s');
    }

    public function isSuccessful()
    {
        return $this->status === 'successful';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
