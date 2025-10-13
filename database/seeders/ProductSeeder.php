<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // تنظيف المنتجات القديمة
        Product::query()->delete();

        // الحصول على المستخدمين
        $merchant = User::where('email', 'merchant@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        if (!$merchant || !$user) {
            echo "❌ لم يتم العثور على المستخدمين المطلوبين\n";
            return;
        }

        // الحصول على التصنيفات
        $clothesCategory = Category::where('slug', 'clothes')->first();
        $electronicsCategory = Category::where('slug', 'electronics')->first();
        $homeCategory = Category::where('slug', 'home')->first();
        $groceryCategory = Category::where('slug', 'grocery')->first();

        if (!$clothesCategory || !$electronicsCategory || !$homeCategory || !$groceryCategory) {
            echo "❌ التصنيفات غير موجودة - تأكد من تشغيل CategorySeeder أولاً\n";
            return;
        }

        // منتجات عادية للتاجر (ليست مستعملة)
        $merchantProducts = [
            [
                'name' => 'هاتف سامسونج جديد',
                'description' => 'هاتف ذكي بمواصفات عالية وكاميرا ممتازة، شاشة 6.7 بوصة، ذاكرة 128 جيجا',
                'price' => 2500.00,
                'category_id' => $electronicsCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
                'views' => 45,
            ],
            [
                'name' => 'تيشيرت قطني',
                'description' => 'تيشيرت قطني مريح ومناسب لجميع الأوقات، متوفر بعدة ألوان ومقاسات',
                'price' => 80.00,
                'category_id' => $clothesCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
                'views' => 23,
            ],
            [
                'name' => 'ساعة ذكية',
                'description' => 'ساعة ذكية بميزات متقدمة وتتبع اللياقة، مقاومة للماء، بطارية طويلة الأمد',
                'price' => 1200.00,
                'category_id' => $electronicsCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
                'views' => 67,
            ],
            [
                'name' => 'طقم أدوات مطبخ',
                'description' => 'طقم أدوات مطبخ متكامل من الاستانلس ستيل، عالي الجودة ومقاوم للصدأ',
                'price' => 350.00,
                'category_id' => $homeCategory->id,
                'user_id' => $merchant->id,
                'is_used' => false,
                'condition' => null,
                'status' => 'active',
                'views' => 34,
            ]
        ];

        foreach ($merchantProducts as $productData) {
            Product::create($productData);
        }

        // منتجات مستعملة للمستخدم العادي
        $usedProducts = [
            [
                'name' => 'هاتف آيفون مستعمل',
                'description' => 'هاتف آيفون مستعمل بحالة جيدة جداً، الشاشة سليمة، البطارية تعمل بشكل ممتاز',
                'price' => 1500.00,
                'category_id' => $electronicsCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جيدة جداً',
                'status' => 'active',
                'views' => 89,
            ],
            [
                'name' => 'ساعة يد مستعملة',
                'description' => 'ساعة يد أنيقة مستعملة، بحالة جيدة، تحتاج لتغيير البطارية',
                'price' => 200.00,
                'category_id' => $electronicsCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جيدة',
                'status' => 'active',
                'views' => 12,
            ],
            [
                'name' => 'كتاب برمجة مستعمل',
                'description' => 'كتاب برمجة مستعمل، يحتوي على شروحات متقدمة في لغة PHP وLaravel',
                'price' => 30.00,
                'category_id' => $homeCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جديدة',
                'status' => 'active',
                'views' => 56,
            ],
            [
                'name' => 'حقيبة ظهر مستعملة',
                'description' => 'حقيبة ظهر بحالة ممتازة، متعددة الجيوب، مناسبة للطلاب والموظفين',
                'price' => 75.00,
                'category_id' => $clothesCategory->id,
                'user_id' => $user->id,
                'is_used' => true,
                'condition' => 'جيدة جداً',
                'status' => 'active',
                'views' => 41,
            ]
        ];

        foreach ($usedProducts as $productData) {
            Product::create($productData);
        }

        echo "✅ تم إنشاء المنتجات بنجاح!\n";
        echo "📦 المنتجات العادية: " . count($merchantProducts) . "\n";
        echo "🔄 المنتجات المستعملة: " . count($usedProducts) . "\n";
        echo "📊 إجمالي المنتجات: " . (count($merchantProducts) + count($usedProducts)) . "\n";
    }
}
