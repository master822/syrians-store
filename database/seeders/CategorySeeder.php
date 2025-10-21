<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // تنظيف الجداول
        if (Schema::hasTable('categories')) {
            \Illuminate\Support\Facades\DB::table('categories')->delete();
        }

        $categories = [
            [
                'name' => 'ملابس',
                'slug' => 'clothes',
                'icon' => 'fas fa-tshirt',
                'description' => 'ملابس متنوعة للرجال والنساء والأطفال',
                'is_active' => true,
            ],
            [
                'name' => 'إلكترونيات',
                'slug' => 'electronics', 
                'icon' => 'fas fa-laptop',
                'description' => 'أجهزة إلكترونية وهواتف وأجهزة كمبيوتر',
                'is_active' => true,
            ],
            [
                'name' => 'أدوات منزلية',
                'slug' => 'home',
                'icon' => 'fas fa-home',
                'description' => 'أدوات ومستلزمات منزلية',
                'is_active' => true,
            ],
            [
                'name' => 'بقالة',
                'slug' => 'grocery',
                'icon' => 'fas fa-shopping-basket',
                'description' => 'مواد غذائية ومنتجات بقالة',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        echo "✅ تم إضافة التصنيفات بنجاح!\n";
    }
}
