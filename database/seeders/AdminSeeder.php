<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        echo "👑 بدء إعداد المسؤولين...\n";

        // التحقق من وجود المسؤول الأساسي
        $adminExists = User::where('email', 'admin@example.com')->exists();
        
        if (!$adminExists) {
            User::create([
                'name' => 'مسؤول النظام',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'admin',
                'phone' => '0912345678',
                'city' => 'دمشق',
                'is_active' => true,
            ]);
            echo "✅ تم إنشاء المسؤول الأساسي\n";
        } else {
            echo "⚠️  المسؤول موجود مسبقاً\n";
        }

        // إنشاء مسؤول إضافي
        $additionalAdmin = User::where('email', 'superadmin@example.com')->first();
        
        if (!$additionalAdmin) {
            User::create([
                'name' => 'المشرف العام',
                'email' => 'superadmin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'admin',
                'phone' => '0912345688',
                'city' => 'دمشق',
                'is_active' => true,
            ]);
            echo "✅ تم إنشاء المشرف العام\n";
        }

        echo "🎉 تم إعداد المسؤولين بنجاح!\n";
        echo "📧 يمكنك الدخول باستخدام:\n";
        echo "   - admin@example.com / password\n";
        echo "   - superadmin@example.com / password\n";
    }
}
