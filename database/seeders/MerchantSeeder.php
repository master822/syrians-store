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
        echo "🛍️  بدء إعداد التجار...\n";

        // التحقق من وجود التجار أولاً لتجنب التكرار
        $existingMerchant = User::where('email', 'merchant@example.com')->first();
        $existingMerchant2 = User::where('email', 'merchant2@example.com')->first();
        $existingUser = User::where('email', 'user@example.com')->first();

        // إنشاء تاجر تجريبي إذا لم يكن موجوداً
        if (!$existingMerchant) {
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
            echo "✅ تم إنشاء التاجر الأول\n";
        } else {
            echo "⚠️  التاجر الأول موجود مسبقاً\n";
        }

        // إنشاء تاجر ثاني إذا لم يكن موجوداً
        if (!$existingMerchant2) {
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
            echo "✅ تم إنشاء التاجر الثاني\n";
        } else {
            echo "⚠️  التاجر الثاني موجود مسبقاً\n";
        }

        // إنشاء مستخدم عادي إذا لم يكن موجوداً
        if (!$existingUser) {
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
            echo "✅ تم إنشاء المستخدم العادي\n";
        } else {
            echo "⚠️  المستخدم العادي موجود مسبقاً\n";
        }

        echo "🎉 تم إعداد التجار والمستخدمين بنجاح!\n";
        echo "📧 البريد: merchant@example.com\n";
        echo "🔐 كلمة المرور: password\n";
    }
}
