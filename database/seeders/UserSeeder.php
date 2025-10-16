<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // مسح المستخدمين الحاليين
        User::query()->delete();

        // إنشاء مسؤول
        User::create([
            'name' => 'مسؤول النظام',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '0912345678',
            'city' => 'دمشق',
            'is_active' => true,
        ]);

        // إنشاء تاجر
        User::create([
            'name' => 'أحمد التاجر',
            'email' => 'merchant@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'merchant',
            'phone' => '0912345679',
            'city' => 'دمشق',
            'store_name' => 'متجر أحمد للإلكترونيات',
            'store_category' => 'electronics',
            'store_description' => 'متخصص في بيع الأجهزة الإلكترونية والهواتف الذكية',
            'store_phone' => '0912345679',
            'store_city' => 'دمشق',
            'product_limit' => 10,
            'is_active' => true,
        ]);

        // إنشاء مستخدم عادي
        User::create([
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'user',
            'phone' => '0912345680',
            'city' => 'دمشق',
            'product_limit' => 5,
            'is_active' => true,
        ]);

        echo "✅ تم إنشاء المستخدمين:\n";
        echo "👑 المسؤول: admin@example.com / password\n";
        echo "🛍️  التاجر: merchant@example.com / password\n";
        echo "👤 المستخدم: user@example.com / password\n";
    }
}
