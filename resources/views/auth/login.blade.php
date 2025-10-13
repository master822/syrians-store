@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="elite-card p-5">
                <div class="text-center mb-5">
                    <h2 class="text-gold mb-3">تسجيل الدخول</h2>
                    <p class="text-light">مرحباً بعودتك!</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-light mb-3">البريد الإلكتروني</label>
                        <input type="email" class="form-control py-3 px-4 @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="أدخل بريدك الإلكتروني">
                        @error('email')
                            <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-light mb-3">كلمة المرور</label>
                        <input type="password" class="form-control py-3 px-4 @error('password') is-invalid @enderror" 
                               id="password" name="password" required
                               placeholder="أدخل كلمة المرور">
                        @error('password')
                            <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-light" for="remember">تذكرني</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn-gold py-3 fs-5">
                            تسجيل الدخول
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-light mb-0">ليس لديك حساب؟ 
                        <a href="{{ route('register') }}" class="text-aqua text-decoration-none fw-bold">إنشاء حساب جديد</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-red-accent {
        color: var(--red-accent) !important;
    }
</style>
@endsection
