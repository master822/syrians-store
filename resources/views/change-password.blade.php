cat > resources/views/change-password.blade.php << 'EOF'
@extends('layouts.app')

@section('title', 'تغيير كلمة المرور')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">تغيير كلمة المرور</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('change-password.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">كلمة المرور الحالية *</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">كلمة المرور الجديدة *</label>
                        <input type="password" name="new_password" class="form-control" required>
                        <small class="text-muted">يجب أن تكون كلمة المرور 8 أحرف على الأقل وتحتوي على حروف وأرقام</small>
                        @error('new_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">تأكيد كلمة المرور الجديدة *</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                        @error('new_password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary">العودة إلى الملف الشخصي</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
}

.alert {
    border-radius: 12px;
    border: none;
}
</style>
@endsection
EOF