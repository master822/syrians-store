<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run()
    {
        // إنشاء تاجر تجريبي
        User::create([
            'name' => 'أحمد التاجر',
            'email' => 'merchant@example.com',
            'password' => Hash::make('password'),
            'phone' => '+905551234567',
            'user_type' => 'merchant',
            'city' => 'إسطنبول',
            'store_name' => 'متجر أحمد للإلكترونيات',
            'store_description' => 'متخصص في بيع الأجهزة الإلكترونية والهواتف الذكية بأفضل الأسعار',
            'store_category' => 'electronics',
            'store_phone' => '+905551234567',
            'store_city' => 'إسطنبول',
            'product_limit' => 10,
            'is_active' => true,
        ]);

        // إنشاء تاجر ثاني
        User::create([
            'name' => 'محمد المحلاتي',
            'email' => 'merchant2@example.com',
            'password' => Hash::make('password'),
            'phone' => '+905551234568',
            'user_type' => 'merchant',
            'city' => 'غازي عنتاب',
            'store_name' => 'سوق محمد للملابس',
            'store_description' => 'أجمل وأحدث موديلات الملابس التركية بأسعار منافسة',
            'store_category' => 'clothes',
            'store_phone' => '+905551234568',
            'store_city' => 'غازي عنتاب',
            'product_limit' => 10,
            'is_active' => true,
        ]);

        // إنشاء مستخدم عادي
        User::create([
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '+905551234569',
            'user_type' => 'user',
            'city' => 'أنقرة',
            'product_limit' => 5,
            'is_active' => true,
        ]);

        $this->command->info('✅ تم إنشاء 2 تاجر و1 مستخدم عادي بنجاح!');
        $this->command->info('📧 البريد: merchant@example.com');
        $this->command->info('🔐 كلمة المرور: password');
    }
}
