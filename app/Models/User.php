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
        'store_name',
        'store_category',
        'store_description',
        'store_phone',
        'store_city',
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
        'subscription_ends_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * العلاقة مع المنتجات (للتجار)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * التحقق إذا كان المستخدم تاجر
     */
    public function isMerchant()
    {
        return $this->user_type === 'merchant';
    }

    /**
     * التحقق إذا كان المستخدم مدير
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * الحصول على اسم فئة المتجر بالعربية
     */
    public function getStoreCategoryName()
    {
        $categories = [
            'clothes' => 'ملابس',
            'electronics' => 'إلكترونيات',
            'home' => 'أدوات منزلية',
            'food' => 'بقالة'
        ];
        
        return $categories[$this->store_category] ?? $this->store_category;
    }
}
