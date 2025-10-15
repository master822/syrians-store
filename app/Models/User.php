<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'city',
        'avatar',
        'store_name',
        'store_category',
        'store_description',
        'store_phone',
        'store_city',
        'store_logo',
        'subscription_plan',
        'product_limit',
        'subscription_ends_at',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'subscription_ends_at' => 'datetime',
    ];

    // العلاقة مع المنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // العلاقة مع التقييمات كتاجر
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'merchant_id');
    }

    // العلاقة مع التقييمات كمستخدم
    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isMerchant()
    {
        return $this->user_type === 'merchant';
    }

    public function isRegularUser()
    {
        return $this->user_type === 'user';
    }

    // الحصول على صورة الملف الشخصي
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=FFFFFF&background=6366f1';
    }

    // الحصول على شعار المتجر
    public function getStoreLogoUrlAttribute()
    {
        if ($this->store_logo) {
            return asset('storage/' . $this->store_logo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->store_name) . '&color=FFFFFF&background=8b5cf6';
    }

    // الحصول على اسم التصنيف بالعربية
    public function getStoreCategoryNameAttribute()
    {
        $categories = [
            'electronics' => 'إلكترونيات',
            'clothes' => 'ملابس',
            'home' => 'أدوات منزلية',
            'grocery' => 'بقالة'
        ];

        return $categories[$this->store_category] ?? 'غير محدد';
    }

    // الحصول على اسم خطة الاشتراك بالعربية
    public function getSubscriptionPlanNameAttribute()
    {
        $plans = [
            'free' => 'مجاني',
            'basic' => 'أساسي',
            'medium' => 'متوسط',
            'premium' => 'مميز'
        ];

        return $plans[$this->subscription_plan] ?? 'غير محدد';
    }

    // التحقق من صلاحية الاشتراك
    public function getIsSubscriptionActiveAttribute()
    {
        if ($this->subscription_plan === 'free') {
            return true;
        }

        return $this->subscription_ends_at && $this->subscription_ends_at->isFuture();
    }
}
