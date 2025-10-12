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
            'store_address' => 'شارع الاستقلال، إسطنبول',
            'store_city' => 'إسطنبول',
            'store_verified' => true,
            'store_opened_at' => now()->subYears(2)
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
            'store_address' => 'شارع الاتحاد، غازي عنتاب',
            'store_city' => 'غازي عنتاب',
            'store_verified' => true,
            'store_opened_at' => now()->subYear()
        ]);

        // إنشاء مستخدم عادي
        User::create([
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '+905551234569',
            'user_type' => 'user',
            'city' => 'أنقرة'
        ]);

        $this->command->info('✅ تم إنشاء 2 تاجر و1 مستخدم عادي بنجاح!');
        $this->command->info('📧 البريد: merchant@example.com');
        $this->command->info('🔐 كلمة المرور: password');
    }
}
