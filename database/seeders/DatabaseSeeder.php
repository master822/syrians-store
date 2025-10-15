<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🔧 بدء إعداد قاعدة البيانات...\n";

        // تنظيف الجداول لـ SQLite
        Schema::disableForeignKeyConstraints();
        
        // تنظيف الجداول فقط إذا كانت موجودة
        $tables = ['users', 'products', 'categories', 'discounts', 'ratings'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->delete();
                echo "✅ تم تنظيف جدول: {$table}\n";
            } else {
                echo "⚠️  جدول غير موجود: {$table}\n";
            }
        }
        
        // إعادة تعيين Auto Increment لـ SQLite
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("DELETE FROM sqlite_sequence WHERE name='{$table}'");
            }
        }
        
        Schema::enableForeignKeyConstraints();

        // إضافة التصنيفات أولاً
        $this->call(CategorySeeder::class);
        
        // إضافة المستخدمين الأساسيين
        $this->createBasicUsers();
        
        // إضافة المنتجات
        $this->createProducts();
        
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

    private function createProducts()
    {
        echo "🔍 التحقق من الجداول المطلوبة للمنتجات...\n";

        // التحقق من وجود الجداول المطلوبة
        $requiredTables = ['products', 'categories', 'users'];
        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                echo "❌ جدول غير موجود: {$table} - تخطي إضافة المنتجات\n";
                return;
            }
        }

        // التحقق من وجود عمود category_id
        if (!Schema::hasColumn('products', 'category_id')) {
            echo "❌ عمود category_id غير موجود في جدول products - تخطي\n";
            return;
        }

        $user = User::where('email', 'user@example.com')->first();
        $merchant = User::where('email', 'merchant@example.com')->first();
        
        if (!$user || !$merchant) {
            echo "❌ المستخدمون غير موجودين - تخطي\n";
            return;
        }

        // الحصول على التصنيفات
        $clothesCategory = Category::where('slug', 'clothes')->first();
        $electronicsCategory = Category::where('slug', 'electronics')->first();
        $homeCategory = Category::where('slug', 'home')->first();
        $groceryCategory = Category::where('slug', 'grocery')->first();

        if (!$clothesCategory || !$electronicsCategory || !$homeCategory || !$groceryCategory) {
            echo "❌ التصنيفات غير موجودة - تخطي\n";
            return;
        }

        // منتجات مستعملة للمستخدم العادي
        $usedProducts = [
            [
                'name' => 'جاكيت شتوي مستعمل',
                'description' => 'جاكيت شتوي بحالة جيدة، مناسب للطقس البارد',
                'price' => 25000,
                'category_id' => $clothesCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جيدة',
                'status' => 'active',
            ],
            [
                'name' => 'هاتف سامسونج مستعمل',
                'description' => 'هاتف سامسونج بحالة ممتازة، شاشة سليمة',
                'price' => 150000,
                'category_id' => $electronicsCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'ممتازة',
                'status' => 'active',
            ],
            [
                'name' => 'طاولة خشب مستعملة',
                'description' => 'طاولة خشب للطعام بحالة جيدة جدا',
                'price' => 45000,
                'category_id' => $homeCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جيدة جدا',
                'status' => 'active',
            ]
        ];

        // منتجات جديدة للتاجر
        $newProducts = [
            [
                'name' => 'لابتوب ديل جديد',
                'description' => 'لابتوب ديل جديد بمواصفات عالية، ضمان سنتين',
                'price' => 450000,
                'category_id' => $electronicsCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
            ],
            [
                'name' => 'سماعات لاسلكية جديدة',
                'description' => 'سماعات لاسلكية عالية الجودة، بطارية طويلة الأمد',
                'price' => 75000,
                'category_id' => $electronicsCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
            ],
            [
                'name' => 'قسماط إيطالي جديد',
                'description' => 'قسماط إيطالي عالي الجودة، طازج ومغلف',
                'price' => 12000,
                'category_id' => $groceryCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
            ]
        ];

        foreach (array_merge($usedProducts, $newProducts) as $productData) {
            Product::create($productData);
        }

        echo "✅ تم إضافة المنتجات\n";
    }
}
