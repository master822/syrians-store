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
        // إذا كان productId = 0 فهو رد على رسالة
        if ($productId == 0 && $request->has('receiver_id')) {
            $request->validate([
                'message' => 'required|string|max:1000',
                'receiver_id' => 'required|exists:users,id'
            ]);

            // إنشاء رسالة رد
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'product_id' => null,
                'message' => $request->message,
                'is_read' => false
            ]);

            return back()->with('success', 'تم إرسال ردك بنجاح!');
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

        return back()->with('success', 'تم إرسال رسالتك إلى التاجر: ' . $product->user->name);
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
}
