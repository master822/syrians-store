<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'price',
        'category_id',
        'user_id',
        'is_used',
        'condition',
        'status',
        'images',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_used' => 'boolean',
        'images' => 'array'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع التصنيف - هذه كانت مفقودة
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // العلاقة مع التخفيضات
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    // العلاقة مع التقييمات
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // نطاق للمنتجات النشطة
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // نطاق للمنتجات المستعملة
    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    // نطاق للمنتجات الجديدة
    public function scopeNew($query)
    {
        return $query->where('is_used', false);
    }
}
