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
        'product_limit',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
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
}
