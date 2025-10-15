<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'user_type' => 'required|in:user,merchant',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'store_name' => 'required_if:user_type,merchant|string|max:255',
            'store_category' => 'required_if:user_type,merchant|in:clothes,electronics,home,grocery',
            'store_description' => 'required_if:user_type,merchant|string|max:500',
            'store_phone' => 'required_if:user_type,merchant|string|max:20',
            'store_city' => 'required_if:user_type,merchant|string|max:255',
        ], [
            'password.regex' => 'يجب أن تحتوي كلمة المرور على حرف كبير وحرف صغير ورقم على الأقل.',
            'password.min' => 'يجب أن تكون كلمة المرور至少 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'store_name.required_if' => 'حقل اسم المتجر مطلوب للتجار.',
            'store_category.required_if' => 'حقل فئة المتجر مطلوب للتجار.',
            'store_description.required_if' => 'حقل وصف المتجر مطلوب للتجار.',
            'store_phone.required_if' => 'حقل هاتف المتجر مطلوب للتجار.',
            'store_city.required_if' => 'حقل مدينة المتجر مطلوب للتجار.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'phone' => $request->phone,
            'city' => $request->city,
            'is_active' => true,
        ];

        // إذا كان تاجراً، أضف بيانات المتجر
        if ($request->user_type === 'merchant') {
            $userData = array_merge($userData, [
                'store_name' => $request->store_name,
                'store_category' => $request->store_category,
                'store_description' => $request->store_description,
                'store_phone' => $request->store_phone,
                'store_city' => $request->store_city,
                'product_limit' => 10,
            ]);
        } else {
            $userData['product_limit'] = 5;
        }

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'تم إنشاء الحساب بنجاح!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
