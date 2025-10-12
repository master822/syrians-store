<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rating;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        // مسح جميع التقييمات الحالية
        Rating::query()->delete();

        // الحصول على التجار
        $merchants = User::where('user_type', 'merchant')->get();
        
        // الحصول على المستخدمين العاديين
        $users = User::where('user_type', 'user')->get();

        // إذا لم يكن هناك مستخدمين عاديين كافيين، أنشئ المزيد
        if ($users->count() < 3) {
            $additionalUsers = [];
            for ($i = 0; $i < 3; $i++) {
                $additionalUsers[] = User::create([
                    'name' => 'مستخدم ' . ($i + 1),
                    'email' => 'user' . ($i + 1) . '@example.com',
                    'password' => bcrypt('password'),
                    'phone' => '+90555123456' . $i,
                    'user_type' => 'user',
                    'city' => 'إسطنبول'
                ]);
            }
            $users = $users->merge($additionalUsers);
        }

        foreach ($merchants as $merchant) {
            // تقييمات للتاجر الأول (أحمد)
            if ($merchant->id == 1) {
                $this->createRatingsForMerchant($merchant, $users, [
                    ['user_index' => 0, 'rating' => 5, 'comment' => 'تاجر ممتاز ومنتجات أصلية، شكراً لك'],
                    ['user_index' => 1, 'rating' => 4, 'comment' => 'جيد ولكن يمكن تحسين وقت التوصيل'],
                    ['user_index' => 2, 'rating' => 5, 'comment' => 'خدمة رائعة وأسعار منافسة'],
                    ['user_index' => 0, 'rating' => 1, 'comment' => 'هذا التاجر ايري وبكسها وما يستاهل', 'is_approved' => false, 'is_flagged' => true, 'moderation_reason' => 'تم اكتشاف كلمات غير لائقة: ايري, بكسها']
                ]);
            } 
            // تقييمات للتاجر الثاني (محمد)
            else {
                $this->createRatingsForMerchant($merchant, $users, [
                    ['user_index' => 0, 'rating' => 4, 'comment' => 'منتجات جيدة وأسعار معقولة'],
                    ['user_index' => 1, 'rating' => 5, 'comment' => 'أفضل تاجر ملابس في المنطقة']
                ]);
            }
        }

        $this->command->info('✅ تم إنشاء التقييمات بنجاح!');
        $this->command->info('📊 إجمالي التقييمات: ' . Rating::count());
    }

    private function createRatingsForMerchant($merchant, $users, $ratingsData)
    {
        foreach ($ratingsData as $ratingData) {
            // التأكد من أن user_index موجود
            if (isset($users[$ratingData['user_index']])) {
                $user = $users[$ratingData['user_index']];
                
                Rating::create([
                    'user_id' => $user->id,
                    'merchant_id' => $merchant->id,
                    'rating' => $ratingData['rating'],
                    'comment' => $ratingData['comment'],
                    'is_approved' => $ratingData['is_approved'] ?? true,
                    'is_flagged' => $ratingData['is_flagged'] ?? false,
                    'moderation_reason' => $ratingData['moderation_reason'] ?? null
                ]);
            }
        }
    }
}
