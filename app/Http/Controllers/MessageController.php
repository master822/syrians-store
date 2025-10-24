<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function contactMerchant(Request $request, $productId)
    {
        // إذا كان productId = 0 فهو رسالة مباشرة بين مستخدمين
        if ($productId == 0 && $request->has('receiver_id')) {
            $request->validate([
                'message' => 'required|string|max:1000',
                'receiver_id' => 'required|exists:users,id'
            ]);

            // إنشاء رسالة مباشرة بين مستخدمين
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'product_id' => null,
                'message' => $request->message,
                'is_read' => false
            ]);

            return back()->with('success', 'تم إرسال رسالتك بنجاح!');
        }

        // رسالة عادية عن منتج
        $product = Product::with('user')->findOrFail($productId);
        
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // إنشاء رسالة جديدة
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->user_id,
            'product_id' => $productId,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'تم إرسال رسالتك إلى: ' . $product->user->name);
    }

    public function inbox()
    {
        $messages = Message::where('receiver_id', Auth::id())
                          ->with(['sender', 'product'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
                          ->with(['receiver', 'product'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('messages.sent', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
                         ->where('receiver_id', Auth::id())
                         ->firstOrFail();

        $message->update(['is_read' => true]);

        return back()->with('success', 'تم تحديد الرسالة كمقروءة');
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
                       ->where('is_read', false)
                       ->count();

        return $count;
    }

    // دالة جديدة للرد المباشر
    public function replyToMessage(Request $request, $messageId)
    {
        $originalMessage = Message::findOrFail($messageId);
        
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // إنشاء رسالة رد
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $originalMessage->sender_id,
            'product_id' => $originalMessage->product_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'تم إرسال ردك بنجاح!');
    }

    // دالة جديدة لإظهار محادثة معينة
    public function showConversation($userId)
    {
        $otherUser = User::findOrFail($userId);
        
        // جلب جميع الرسائل بين المستخدم الحالي والمستخدم الآخر
        $messages = Message::where(function($query) use ($userId) {
                            $query->where('sender_id', Auth::id())
                                  ->where('receiver_id', $userId);
                        })
                        ->orWhere(function($query) use ($userId) {
                            $query->where('sender_id', $userId)
                                  ->where('receiver_id', Auth::id());
                        })
                        ->with(['sender', 'receiver', 'product'])
                        ->orderBy('created_at', 'asc')
                        ->get();

        // تحديد الرسائل كمقروءة
        Message::where('sender_id', $userId)
               ->where('receiver_id', Auth::id())
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return view('messages.conversation', compact('messages', 'otherUser'));
    }

    // دالة جديدة لإرسال رسالة في محادثة
    public function sendMessageInConversation(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // إنشاء رسالة جديدة في المحادثة
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'product_id' => $request->product_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }

    // دالة جديدة للتواصل مع بائع منتج مستعمل
    public function contactProductSeller(Request $request, $productId)
    {
        $product = Product::with('user')->findOrFail($productId);
        
        // التحقق من أن المنتج مستعمل ومملوك لمستخدم عادي
        if (!$product->is_used || $product->user->user_type !== 'user') {
            return back()->with('error', 'لا يمكن التواصل مع بائع هذا المنتج');
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // إنشاء رسالة للمستخدم البائع
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->user_id,
            'product_id' => $productId,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'تم إرسال رسالتك إلى البائع: ' . $product->user->name);
    }
}
