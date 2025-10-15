@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-dark">إنشاء حساب جديد</h4>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">رقم الهاتف *</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">البلد *</label>
                        <select name="city" class="form-select" required>
                            <option value="">اختر البلد</option>
                            <option value="السعودية" {{ old('city') == 'السعودية' ? 'selected' : '' }}>السعودية</option>
                            <option value="الإمارات" {{ old('city') == 'الإمارات' ? 'selected' : '' }}>الإمارات</option>
                            <option value="قطر" {{ old('city') == 'قطر' ? 'selected' : '' }}>قطر</option>
                            <option value="الكويت" {{ old('city') == 'الكويت' ? 'selected' : '' }}>الكويت</option>
                            <option value="البحرين" {{ old('city') == 'البحرين' ? 'selected' : '' }}>البحرين</option>
                            <option value="عمان" {{ old('city') == 'عمان' ? 'selected' : '' }}>عمان</option>
                            <option value="تركيا" {{ old('city') == 'تركيا' ? 'selected' : '' }}>تركيا</option>
                            <option value="مصر" {{ old('city') == 'مصر' ? 'selected' : '' }}>مصر</option>
                            <option value="الأردن" {{ old('city') == 'الأردن' ? 'selected' : '' }}>الأردن</option>
                            <option value="لبنان" {{ old('city') == 'لبنان' ? 'selected' : '' }}>لبنان</option>
                            <option value="العراق" {{ old('city') == 'العراق' ? 'selected' : '' }}>العراق</option>
                            <option value="سوريا" {{ old('city') == 'سوريا' ? 'selected' : '' }}>سوريا</option>
                            <option value="اليمن" {{ old('city') == 'اليمن' ? 'selected' : '' }}>اليمن</option>
                            <option value="فلسطين" {{ old('city') == 'فلسطين' ? 'selected' : '' }}>فلسطين</option>
                            <option value="الولايات المتحدة" {{ old('city') == 'الولايات المتحدة' ? 'selected' : '' }}>الولايات المتحدة</option>
                            <option value="بريطانيا" {{ old('city') == 'بريطانيا' ? 'selected' : '' }}>بريطانيا</option>
                            <option value="ألمانيا" {{ old('city') == 'ألمانيا' ? 'selected' : '' }}>ألمانيا</option>
                            <option value="فرنسا" {{ old('city') == 'فرنسا' ? 'selected' : '' }}>فرنسا</option>
                            <option value="كندا" {{ old('city') == 'كندا' ? 'selected' : '' }}>كندا</option>
                            <option value="أستراليا" {{ old('city') == 'أستراليا' ? 'selected' : '' }}>أستراليا</option>
                            <option value="الصين" {{ old('city') == 'الصين' ? 'selected' : '' }}>الصين</option>
                            <option value="اليابان" {{ old('city') == 'اليابان' ? 'selected' : '' }}>اليابان</option>
                            <option value="كوريا الجنوبية" {{ old('city') == 'كوريا الجنوبية' ? 'selected' : '' }}>كوريا الجنوبية</option>
                            <option value="الهند" {{ old('city') == 'الهند' ? 'selected' : '' }}>الهند</option>
                            <option value="باكستان" {{ old('city') == 'باكستان' ? 'selected' : '' }}>باكستان</option>
                        </select>
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">نوع الحساب *</label>
                        <select name="user_type" class="form-select" required id="userType">
                            <option value="">اختر نوع الحساب</option>
                            <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                            <option value="merchant" {{ old('user_type') == 'merchant' ? 'selected' : '' }}>تاجر</option>
                        </select>
                        @error('user_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- حقول التاجر -->
                    <div id="merchantFields" style="display: {{ old('user_type') == 'merchant' ? 'block' : 'none' }};">
                        <div class="mb-3">
                            <label class="form-label text-dark">اسم المتجر *</label>
                            <input type="text" name="store_name" class="form-control" value="{{ old('store_name') }}">
                            @error('store_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">فئة المتجر *</label>
                            <select name="store_category" class="form-select">
                                <option value="">اختر فئة المتجر</option>
                                <option value="electronics" {{ old('store_category') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                <option value="clothes" {{ old('store_category') == 'clothes' ? 'selected' : '' }}>ملابس</option>
                                <option value="home" {{ old('store_category') == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                                <option value="grocery" {{ old('store_category') == 'grocery' ? 'selected' : '' }}>بقالة</option>
                            </select>
                            @error('store_category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">وصف المتجر *</label>
                            <textarea name="store_description" class="form-control" rows="3">{{ old('store_description') }}</textarea>
                            @error('store_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">هاتف المتجر *</label>
                            <input type="text" name="store_phone" class="form-control" value="{{ old('store_phone') }}">
                            @error('store_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">مدينة المتجر *</label>
                            <input type="text" name="store_city" class="form-control" value="{{ old('store_city') }}">
                            @error('store_city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">كلمة المرور *</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">يجب أن تحتوي كلمة المرور على الأقل على 8 أحرف، حرف كبير، حرف صغير، ورقم</small>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">إنشاء الحساب</button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p class="text-muted">لديك حساب بالفعل؟ 
                            <a href="{{ route('login') }}" class="text-primary">سجل الدخول</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('userType').addEventListener('change', function() {
        const merchantFields = document.getElementById('merchantFields');
        if (this.value === 'merchant') {
            merchantFields.style.display = 'block';
            // جعل الحقول إلزامية
            const merchantInputs = merchantFields.querySelectorAll('input, select, textarea');
            merchantInputs.forEach(input => {
                input.setAttribute('required', 'required');
            });
        } else {
            merchantFields.style.display = 'none';
            // إزالة الإلزامية
            const merchantInputs = merchantFields.querySelectorAll('input, select, textarea');
            merchantInputs.forEach(input => {
                input.removeAttribute('required');
            });
        }
    });

    // عند تحميل الصفحة، تأكد من إظهار حقول التاجر إذا كان النوع تاجر
    document.addEventListener('DOMContentLoaded', function() {
        const userType = document.getElementById('userType');
        if (userType.value === 'merchant') {
            const merchantFields = document.getElementById('merchantFields');
            merchantFields.style.display = 'block';
        }
    });
</script>
@endsection
