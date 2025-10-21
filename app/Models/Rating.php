<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'merchant_id', 
        'rating',
        'comment',
        'is_approved',
        'is_flagged',
        'moderation_reason'
    ];

    // العلاقة مع المستخدم الذي قام بالتقييم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // العلاقة مع التاجر الذي تم تقييمه
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    // نطاق للتقييمات المعتمدة
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // نطاق للتقييمات غير المعتمدة
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // نطاق للتقييمات المفعلة
    public function scopeActive($query)
    {
        return $query->where('is_approved', true)->where('is_flagged', false);
    }
}
