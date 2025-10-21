<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function globalChat()
    {
        return view('chat.global');
    }

    public function sendGlobalMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // هنا يمكنك حفظ الرسالة في جدول المحادثات العالمية
        // هذا مثال مبسط
        broadcast(new \App\Events\GlobalMessage($request->message, Auth::user()));

        return response()->json(['status' => 'success']);
    }

    public function getGlobalMessages()
    {
        // جلب آخر الرسائل من المحادثة العالمية
        $messages = []; // استبدل هذا بالاستعلام الحقيقي
        return response()->json($messages);
    }
}
