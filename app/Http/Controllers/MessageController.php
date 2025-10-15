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
}
