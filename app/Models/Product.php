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
        'views',
        'discount_percentage',
        'discount_images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_used' => 'boolean',
        'images' => 'array',
        'discount_images' => 'array'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع التصنيف
    public function category()
    {
        return $this->belongsTo(Category::class);
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

    // نطاق للمنتجات المخفضة
    public function scopeDiscounted($query)
    {
        return $query->where('discount_percentage', '>', 0);
    }

    // حساب السعر بعد الخصم
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->price - ($this->price * $this->discount_percentage / 100);
        }
        return $this->price;
    }

    // التحقق مما إذا كان المنتج مخفضاً
    public function getIsDiscountedAttribute()
    {
        return $this->discount_percentage > 0;
    }
}
