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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_used', false);
    }

    public function scopeDiscounted($query)
    {
        return $query->where('discount_percentage', '>', 0);
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->price - ($this->price * $this->discount_percentage / 100);
        }
        return $this->price;
    }

    public function getIsDiscountedAttribute()
    {
        return $this->discount_percentage > 0;
    }

    public function getFirstImageAttribute()
    {
        if ($this->images) {
            $imagesArray = json_decode($this->images, true);
            if (is_array($imagesArray) && count($imagesArray) > 0 && !empty($imagesArray[0])) {
                return asset('storage/' . $imagesArray[0]);
            }
        }
        return 'https://via.placeholder.com/300x200/f8f9fa/6c757d?text=No+Image';
    }
}
