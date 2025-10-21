<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // إذا كان تاجراً، التحقق من بيانات المتجر
        if ($user->user_type === 'merchant') {
            $request->validate([
                'store_name' => 'required|string|max:255',
                'store_category' => 'required|in:clothes,electronics,home,grocery',
                'store_description' => 'required|string|max:500',
                'store_phone' => 'required|string|max:20',
                'store_city' => 'required|string|max:255',
                'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        }

        // تحديث البيانات الأساسية
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;

        // تحديث صورة الملف الشخصي
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // إذا كان تاجراً، تحديث بيانات المتجر
        if ($user->user_type === 'merchant') {
            $user->store_name = $request->store_name;
            $user->store_category = $request->store_category;
            $user->store_description = $request->store_description;
            $user->store_phone = $request->store_phone;
            $user->store_city = $request->store_city;

            // تحديث شعار المتجر
            if ($request->hasFile('store_logo')) {
                // حذف الشعار القديم إذا كان موجوداً
                if ($user->store_logo) {
                    Storage::disk('public')->delete($user->store_logo);
                }
                $logoPath = $request->file('store_logo')->store('store-logos', 'public');
                $user->store_logo = $logoPath;
            }
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }

    public function showChangePassword()
    {
        return view('change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        // تحديث كلمة المرور
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }

    public function showChat()
    {
        return view('chat');
    }
}
