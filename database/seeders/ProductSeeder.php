<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // تنظيف المنتجات القديمة
        Product::query()->delete();

        // الحصول على المستخدمين
        $merchant = User::where('user_type', 'merchant')->first();
        $user = User::where('user_type', 'user')->first();

        if (!$merchant || !$user) {
            $this->command->error('❌ لم يتم العثور على المستخدمين المطلوبين');
            return;
        }

        // منتجات عادية للتاجر (ليست مستعملة)
        $merchantProducts = [
            [
                'name' => 'هاتف سامسونج جديد',
                'description' => 'هاتف ذكي بمواصفات عالية وكاميرا ممتازة',
                'price' => 2500.00,
                'category' => 'electronics',
                'is_used' => false,
                'is_active' => true,
            ],
            [
                'name' => 'قلم جاف فاخر',
                'description' => 'قلم جاف عالي الجودة للكتابة اليومية',
                'price' => 50.00,
                'category' => 'home',
                'is_used' => false,
                'is_active' => true,
            ],
            [
                'name' => 'تيشيرت قطني',
                'description' => 'تيشيرت قطني مريح ومناسب لجميع الأوقات',
                'price' => 80.00,
                'category' => 'clothes',
                'is_used' => false,
                'is_active' => true,
            ],
            [
                'name' => 'ساعة ذكية',
                'description' => 'ساعة ذكية بميزات متقدمة وتتبع اللياقة',
                'price' => 1200.00,
                'category' => 'electronics',
                'is_used' => false,
                'is_active' => true,
            ]
        ];

        foreach ($merchantProducts as $productData) {
            Product::create(array_merge($productData, [
                'user_id' => $merchant->id,
                'discount_images' => null,
                'discount_percentage' => 0,
                'stock' => 10,
                'features' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // منتجات مستعملة للمستخدم العادي
        $usedProducts = [
            [
                'name' => 'هاتف آيفون مستعمل',
                'description' => 'هاتف آيفون مستعمل بحالة جيدة جداً\n\nحالة المنتج: جيد جدا',
                'price' => 1500.00,
                'category' => 'electronics',
                'is_used' => true,
                'is_active' => true,
            ],
            [
                'name' => 'ساعة يد مستعملة',
                'description' => 'ساعة يد أنيقة مستعملة\n\nحالة المنتج: جيد',
                'price' => 200.00,
                'category' => 'electronics',
                'is_used' => true,
                'is_active' => true,
            ],
            [
                'name' => 'كتاب مستعمل',
                'description' => 'كتاب برمجة مستعمل\n\nحالة المنتج: جديد',
                'price' => 30.00,
                'category' => 'home',
                'is_used' => true,
                'is_active' => true,
            ],
            [
                'name' => 'حقيبة ظهر مستعملة',
                'description' => 'حقيبة ظهر بحالة ممتازة\n\nحالة المنتج: جيد جدا',
                'price' => 75.00,
                'category' => 'clothes',
                'is_used' => true,
                'is_active' => true,
            ]
        ];

        foreach ($usedProducts as $productData) {
            Product::create(array_merge($productData, [
                'user_id' => $user->id,
                'discount_images' => null,
                'discount_percentage' => 0,
                'stock' => 1,
                'features' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ تم إنشاء المنتجات بنجاح!');
        $this->command->info('📦 المنتجات العادية: ' . count($merchantProducts));
        $this->command->info('🔄 المنتجات المستعملة: ' . count($usedProducts));
    }
}
