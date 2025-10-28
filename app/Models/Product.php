<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = ['first_image_url', 'image_urls', 'has_images'];

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

    // الحصول على مصفوفة الصور
    public function getImagesArrayAttribute()
    {
        if (!$this->images) {
            return [];
        }
        
        try {
            $images = json_decode($this->images, true);
            return is_array($images) ? $images : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    // التحقق من وجود الصور
    public function getHasImagesAttribute()
    {
        return !empty($this->images_array);
    }

    // الحصول على روابط الصور للعرض
    public function getImageUrlsAttribute()
    {
        $images = $this->images_array;
        $urls = [];
        
        foreach ($images as $image) {
            if ($image) {
                // استخدام المسار المباشر للتخزين
                $urls[] = asset('storage/' . $image);
            }
        }
        
        // إذا لم توجد صور، استخدم صورة افتراضية
        if (empty($urls)) {
            $urls[] = $this->getDefaultImage();
        }
        
        return $urls;
    }

    // الحصول على الصورة الأولى
    public function getFirstImageUrlAttribute()
    {
        $images = $this->image_urls;
        return $images[0];
    }

    // صورة افتراضية
    private function getDefaultImage()
    {
        return 'https://via.placeholder.com/400x300/6366f1/ffffff?text=' . urlencode($this->name);
    }

    public function getDiscountPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->price - ($this->price * $this->discount_percentage / 100);
        }
        return $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNew($query)
    {
        return $query->where('is_used', false);
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    public function scopeWithDiscount($query)
    {
        return $query->where('discount_percentage', '>', 0);
    }
}
