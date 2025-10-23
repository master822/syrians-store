<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_type',
        'amount',
        'payment_method',
        'payment_id',
        'status',
        'starts_at',
        'ends_at',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPlanNameAttribute()
    {
        $plans = [
            'free' => 'مجاني',
            'basic' => 'الأساسي',
            'medium' => 'المتوسط', 
            'premium' => 'المميز'
        ];

        return $plans[$this->plan_type] ?? $this->plan_type;
    }

    public function getProductLimitAttribute()
    {
        $limits = [
            'free' => 5,
            'basic' => 20,
            'medium' => 40,
            'premium' => 9999 // unlimited
        ];

        return $limits[$this->plan_type] ?? 5;
    }

    public function getIsActiveAttribute()
    {
        if ($this->status !== 'completed') {
            return false;
        }

        return $this->ends_at && $this->ends_at->isFuture();
    }
}
