@extends('layouts.app')

@section('title', 'تغيير كلمة المرور - متجر التخفيضات')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        تغيير كلمة المرور
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('change-password.update') }}" method="POST">
                        @csrf
                        
                        <!-- كلمة المرور الحالية -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label text-light">
                                كلمة المرور الحالية <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control dark-input" 
                                       id="current_password" name="current_password" required>
                                <button type="button" class="btn btn-outline-aqua toggle-password" 
                                        data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- كلمة المرور الجديدة -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label text-light">
                                كلمة المرور الجديدة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control dark-input" 
                                       id="new_password" name="new_password" required>
                                <button type="button" class="btn btn-outline-aqua toggle-password" 
                                        data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text text-muted">
                                يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل
                            </div>
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- تأكيد كلمة المرور الجديدة -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label text-light">
                                تأكيد كلمة المرور الجديدة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control dark-input" 
                                       id="new_password_confirmation" name="new_password_confirmation" required>
                                <button type="button" class="btn btn-outline-aqua toggle-password" 
                                        data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- مؤشر قوة كلمة المرور -->
                        <div class="mb-4">
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-level" id="passwordStrength"></div>
                                </div>
                                <div class="strength-text text-muted small mt-1" id="passwordText">
                                    قوة كلمة المرور
                                </div>
                            </div>
                        </div>

                        <!-- نصائح الأمان -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-shield-alt me-2"></i>نصائح لأمان أفضل:</h6>
                            <ul class="mb-0 small">
                                <li>استخدم مزيجاً من الأحرف الكبيرة والصغيرة</li>
                                <li>أضف أرقاماً ورموزاً خاصة (@, #, $, إلخ)</li>
                                <li>لا تستخدم كلمات مرور مستخدمة مسبقاً</li>
                                <li>تجنب المعلومات الشخصية مثل تاريخ الميلاد</li>
                            </ul>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('profile') }}" class="btn btn-outline-aqua">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-save me-2"></i>تغيير كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تبديل إظهار/إخفاء كلمة المرور
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // فحص قوة كلمة المرور
    const passwordInput = document.getElementById('new_password');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let text = '';
        let color = '';

        // التحقق من طول كلمة المرور
        if (password.length >= 8) strength += 25;
        
        // التحقق من وجود أحرف كبيرة وصغيرة
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
        
        // التحقق من وجود أرقام
        if (password.match(/\d/)) strength += 25;
        
        // التحقق من وجود رموز خاصة
        if (password.match(/[^a-zA-Z\d]/)) strength += 25;

        // تحديد النص واللون بناءً على القوة
        if (strength === 0) {
            text = 'قوة كلمة المرور';
            color = 'transparent';
        } else if (strength <= 25) {
            text = 'ضعيفة';
            color = '#dc3545';
        } else if (strength <= 50) {
            text = 'متوسطة';
            color = '#fd7e14';
        } else if (strength <= 75) {
            text = 'جيدة';
            color = '#ffc107';
        } else {
            text = 'قوية جداً';
            color = '#20c997';
        }

        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
});
</script>

<style>
.dark-input {
    background: var(--dark-surface);
    border: 1px solid var(--dark-border);
    color: var(--text-primary);
}

.dark-input:focus {
    background: var(--dark-surface);
    border-color: var(--gold-primary);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.password-strength {
    margin-top: 10px;
}

.strength-bar {
    width: 100%;
    height: 8px;
    background: var(--dark-surface);
    border-radius: 4px;
    overflow: hidden;
}

.strength-level {
    height: 100%;
    width: 0;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.alert-info {
    background: rgba(32, 201, 151, 0.1);
    border: 1px solid var(--aqua-primary);
    color: var(--text-primary);
}

.input-group .btn {
    border: 1px solid var(--dark-border);
    border-left: none;
}

.input-group .btn:hover {
    background: var(--aqua-primary);
    color: #000;
}
</style>
@endsection
