<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;

class RatingController extends Controller
{
    // قائمة الكلمات الممنوعة
    private $bannedWords = [
        'ايري', 'بكسها', 'ايري بيها', 'يلعن', 'انيكك', 'كس امك', 'خرقها', 'يلعن تبعها',
        'fuck', 'shit', 'asshole', 'bitch', 'dick', 'pussy', 'motherfucker',
        'قحبة', 'شرموطة', 'عاهر', 'زانية', 'كلب', 'حمار'
    ];

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:5|max:500'
        ]);

        // فحص التعليق بحثاً عن كلمات ممنوعة
        $moderationResult = $this->moderateComment($request->comment);

        if (!$moderationResult['approved']) {
            return back()->with('error', 'التعليق يحتوي على كلمات غير لائقة: ' . $moderationResult['reason']);
        }

        // إنشاء التقييم
        $rating = Rating::create([
            'user_id' => auth()->id(),
            'merchant_id' => $request->merchant_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => $moderationResult['approved'],
            'is_flagged' => $moderationResult['flagged'],
            'moderation_reason' => $moderationResult['reason']
        ]);

        return back()->with('success', 'تم إضافة التقييم بنجاح ' . ($moderationResult['approved'] ? '' : '(بانتظار المراجعة)'));
    }

    // دالة الفلترة
    private function moderateComment($comment)
    {
        $commentLower = mb_strtolower($comment, 'UTF-8');
        $foundWords = [];

        foreach ($this->bannedWords as $word) {
            if (mb_strpos($commentLower, mb_strtolower($word, 'UTF-8')) !== false) {
                $foundWords[] = $word;
            }
        }

        if (!empty($foundWords)) {
            return [
                'approved' => false,
                'flagged' => true,
                'reason' => implode(', ', $foundWords)
            ];
        }

        return [
            'approved' => true,
            'flagged' => false,
            'reason' => null
        ];
    }

    public function index($merchantId)
    {
        $ratings = Rating::where('merchant_id', $merchantId)
            ->where('is_approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $average = Rating::where('merchant_id', $merchantId)
            ->where('is_approved', true)
            ->avg('rating');

        return response()->json([
            'ratings' => $ratings,
            'average' => round($average, 1),
            'count' => $ratings->count()
        ]);
    }
}
