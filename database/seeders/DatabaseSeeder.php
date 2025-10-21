<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🔧 بدء إعداد قاعدة البيانات...\n";

        // تعطيل فحص المفاتيح الأجنبية مؤقتاً
        Schema::disableForeignKeyConstraints();
        
        // تنظيف الجداول بشكل آمن
        $tables = ['ratings', 'products', 'categories', 'users'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->delete();
                echo "✅ تم تنظيف جدول: {$table}\n";
            }
        }
        
        // إعادة تعيين Auto Increment
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("DELETE FROM sqlite_sequence WHERE name='{$table}'");
            }
        }
        
        Schema::enableForeignKeyConstraints();

        // إضافة التصنيفات أولاً (مهم للمنتجات)
        $this->call(CategorySeeder::class);
        
        // إضافة المستخدمين الأساسيين
        $this->createBasicUsers();
        
        // إضافة المنتجات
        $this->call(ProductSeeder::class);
        
        // إضافة التخفيضات
        $this->call(DiscountSeeder::class);
        
        // إضافة التقييمات
        $this->call(RatingsTableSeeder::class);

        echo "🎉 تم إعداد قاعدة البيانات بنجاح!\n";
    }

    private function createBasicUsers()
    {
        // إنشاء المستخدمين باستخدام الموديل
        User::create([
            'name' => 'مسؤول النظام',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '0912345678',
            'city' => 'دمشق',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'أحمد التاجر',
            'email' => 'merchant@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
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

        User::create([
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'user_type' => 'user',
            'phone' => '0912345680',
            'city' => 'دمشق',
            'product_limit' => 5,
            'is_active' => true,
        ]);

        echo "✅ تم إضافة المستخدمين الأساسيين\n";
    }
}
