<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        echo "🎯 بدء إضافة التخفيضات...\n";

        // الحصول على التاجر
        $merchant = User::where('email', 'merchant@example.com')->first();
        
        if (!$merchant) {
            echo "❌ لم يتم العثور على التاجر\n";
            return;
        }

        // الحصول على منتجات التاجر
        $products = Product::where('user_id', $merchant->id)
                          ->where('is_used', false)
                          ->get();

        if ($products->isEmpty()) {
            echo "❌ لا توجد منتجات للتاجر\n";
            return;
        }

        // تطبيق تخفيضات على بعض المنتجات
        $discountedProducts = $products->take(2);
        
        foreach ($discountedProducts as $index => $product) {
            $discountPercentage = $index == 0 ? 15 : 25; // 15% و 25%
            
            $product->update([
                'discount_percentage' => $discountPercentage,
                'updated_at' => now()
            ]);
            
            echo "✅ تم تطبيق تخفيض {$discountPercentage}% على: {$product->name}\n";
        }

        echo "🎉 تم إضافة التخفيضات بنجاح!\n";
    }
}
