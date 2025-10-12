<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'percentage' => 'decimal:2'
    ];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'غير نشط';
        }

        $now = now();
        if ($now < $this->start_date) {
            return 'قادم';
        } elseif ($now > $this->end_date) {
            return 'منتهي';
        } else {
            return 'نشط';
        }
    }
}
