@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-dark">تسجيل الدخول</h4>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">كلمة المرور *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-dark" for="remember">تذكرني</label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="text-muted">ليس لديك حساب؟ 
                            <a href="{{ route('register') }}" class="text-primary">إنشاء حساب جديد</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
