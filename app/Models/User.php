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
        'product_limit',
        'current_plan',
        'subscription_start',
        'subscription_end',
        'is_trial_used',
        'is_active',
        'trial_days'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_start' => 'datetime',
        'subscription_end' => 'datetime',
        'is_trial_used' => 'boolean',
        'is_active' => 'boolean',
    ];

    // العلاقات
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'merchant_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // النطاقات (Scopes)
    public function scopeMerchants($query)
    {
        return $query->where('user_type', 'merchant');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // السمات (Attributes)
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // صورة افتراضية حسب نوع المستخدم
        if ($this->user_type === 'merchant') {
            return 'https://cdn-icons-png.flaticon.com/512/869/869636.png';
        } elseif ($this->user_type === 'admin') {
            return 'https://cdn-icons-png.flaticon.com/512/2206/2206368.png';
        } else {
            return 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
        }
    }

    public function getStoreLogoUrlAttribute()
    {
        if ($this->store_logo) {
            return asset('storage/' . $this->store_logo);
        }
        return 'https://cdn-icons-png.flaticon.com/512/869/869636.png';
    }

    public function getSubscriptionPlanNameAttribute()
    {
        $plans = [
            'free' => 'مجاني',
            'basic' => 'أساسي',
            'medium' => 'متوسط',
            'premium' => 'مميز'
        ];

        return $plans[$this->current_plan] ?? 'مجاني';
    }

    // دالة للحصول على اسم الفئة بالعربية
    public function getCategoryName($category)
    {
        $categories = [
            'clothes' => 'ملابس',
            'electronics' => 'إلكترونيات',
            'home' => 'أدوات منزلية',
            'grocery' => 'بقالة'
        ];

        return $categories[$category] ?? 'غير محدد';
    }

    public function isMerchant()
    {
        return $this->user_type === 'merchant';
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isUser()
    {
        return $this->user_type === 'user';
    }

    public function hasActiveSubscription()
    {
        if ($this->current_plan === 'free') {
            return true; // الخطة المجانية دائماً نشطة
        }

        return $this->subscription_end && $this->subscription_end->isFuture();
    }

    public function canAddMoreProducts()
    {
        $currentCount = $this->products()->count();
        return $currentCount < $this->product_limit;
    }

    public function remainingProductSlots()
    {
        $currentCount = $this->products()->count();
        return max(0, $this->product_limit - $currentCount);
    }

    // حساب متوسط التقييم للتاجر
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    // عدد التقييمات للتاجر
    public function getRatingsCountAttribute()
    {
        return $this->ratings()->count();
    }

    // عدد المنتجات النشطة
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->where('status', 'active')->count();
    }

    // التحقق من الفترة التجريبية
    public function isInTrialPeriod()
    {
        if ($this->is_trial_used) {
            return false;
        }

        $trialEndsAt = $this->created_at->addDays($this->trial_days ?? 60);
        return now()->lessThan($trialEndsAt);
    }

    // الأيام المتبقية في الفترة التجريبية
    public function getTrialDaysLeftAttribute()
    {
        if ($this->is_trial_used) {
            return 0;
        }

        $trialEndsAt = $this->created_at->addDays($this->trial_days ?? 60);
        return max(0, now()->diffInDays($trialEndsAt, false));
    }
}
