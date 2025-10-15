<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpdateDatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🚀 بدء تحديث قاعدة البيانات...\n";

        // تشغيل السيدرات بالترتيب مع معالجة الأخطاء
        try {
            $this->call(CategorySeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في CategorySeeder: " . $e->getMessage() . "\n";
        }

        try {
            $this->call(AdminSeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في AdminSeeder: " . $e->getMessage() . "\n";
        }

        try {
            $this->call(MerchantSeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في MerchantSeeder: " . $e->getMessage() . "\n";
        }

        try {
            $this->call(ProductSeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في ProductSeeder: " . $e->getMessage() . "\n";
        }

        try {
            $this->call(DiscountSeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في DiscountSeeder: " . $e->getMessage() . "\n";
        }

        try {
            $this->call(RatingsTableSeeder::class);
        } catch (\Exception $e) {
            echo "⚠️  تحذير في RatingsTableSeeder: " . $e->getMessage() . "\n";
        }

        echo "🎊 تم تحديث قاعدة البيانات بنجاح!\n";
        echo "\n📋 ملخص الحسابات المتاحة:\n";
        echo "👑 المسؤول: admin@example.com / password\n";
        echo "👑 المشرف: superadmin@example.com / password\n";
        echo "🛍️  التاجر: merchant@example.com / password\n";
        echo "👤 المستخدم: user@example.com / password\n";
    }
}
