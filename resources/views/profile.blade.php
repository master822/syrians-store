@extends('layouts.app')

@section('title', 'الملف الشخصي - متجر التخفيضات')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        الملف الشخصي
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- صورة الملف الشخصي -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ Auth::user()->avatar_url }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="rounded-circle mb-3 user-profile-image"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--gold-primary);">
                                <label for="avatar" class="btn btn-aqua btn-sm position-absolute bottom-0 end-0 rounded-circle"
                                       style="width: 35px; height: 35px; cursor: pointer;">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                            </div>
                            <div class="form-text text-muted">انقر على الكاميرا لتغيير الصورة</div>
                        </div>

                        <div class="row">
                            <!-- الاسم -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-light">الاسم الكامل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dark-input" id="name" name="name" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-light">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" class="form-control dark-input" id="email" name="email" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- الهاتف -->
                        <div class="mb-3">
                            <label for="phone" class="form-label text-light">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control dark-input" id="phone" name="phone" 
                                   value="{{ old('phone', Auth::user()->phone) }}" required>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- المدينة -->
                        <div class="mb-3">
                            <label for="city" class="form-label text-light">المدينة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control dark-input" id="city" name="city" 
                                   value="{{ old('city', Auth::user()->city) }}" required>
                            @error('city')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(Auth::user()->user_type === 'merchant')
                        <!-- معلومات المتجر -->
                        <div class="border-top border-secondary pt-4 mt-4">
                            <h5 class="text-gold mb-4">
                                <i class="fas fa-store me-2"></i>معلومات المتجر
                            </h5>
                            
                            <!-- شعار المتجر -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ Auth::user()->store_logo_url }}" 
                                         alt="{{ Auth::user()->store_name }}" 
                                         class="rounded mb-3 store-logo-image"
                                         style="width: 150px; height: 80px; object-fit: contain; border: 2px solid var(--gold-primary); background: var(--dark-surface);">
                                    <label for="store_logo" class="btn btn-aqua btn-sm position-absolute bottom-0 end-0 rounded-circle"
                                           style="width: 35px; height: 35px; cursor: pointer;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" id="store_logo" name="store_logo" class="d-none" accept="image/*">
                                </div>
                                <div class="form-text text-muted">شعار المتجر (الحجم الموصى به: 300x150 بكسل)</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="store_name" class="form-label text-light">اسم المتجر <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control dark-input" id="store_name" name="store_name" 
                                           value="{{ old('store_name', Auth::user()->store_name) }}" required>
                                    @error('store_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="store_category" class="form-label text-light">تصنيف المتجر <span class="text-danger">*</span></label>
                                    <select class="form-control dark-input" id="store_category" name="store_category" required>
                                        <option value="electronics" {{ Auth::user()->store_category == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                        <option value="clothes" {{ Auth::user()->store_category == 'clothes' ? 'selected' : '' }}>ملابس</option>
                                        <option value="home" {{ Auth::user()->store_category == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                                        <option value="grocery" {{ Auth::user()->store_category == 'grocery' ? 'selected' : '' }}>بقالة</option>
                                    </select>
                                    @error('store_category')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="store_description" class="form-label text-light">وصف المتجر <span class="text-danger">*</span></label>
                                <textarea class="form-control dark-input" id="store_description" name="store_description" 
                                          rows="3" required>{{ old('store_description', Auth::user()->store_description) }}</textarea>
                                @error('store_description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="store_phone" class="form-label text-light">هاتف المتجر <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control dark-input" id="store_phone" name="store_phone" 
                                           value="{{ old('store_phone', Auth::user()->store_phone) }}" required>
                                    @error('store_phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="store_city" class="form-label text-light">مدينة المتجر <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control dark-input" id="store_city" name="store_city" 
                                           value="{{ old('store_city', Auth::user()->store_city) }}" required>
                                    @error('store_city')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- معلومات الحساب -->
                        <div class="border-top border-secondary pt-4 mt-4">
                            <h5 class="text-gold mb-3">معلومات الحساب</h5>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong class="text-aqua">نوع الحساب:</strong>
                                    <span class="text-light ms-2">
                                        @if(Auth::user()->user_type == 'admin')
                                            مسؤول
                                        @elseif(Auth::user()->user_type == 'merchant')
                                            تاجر
                                        @else
                                            مستخدم عادي
                                        @endif
                                    </span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong class="text-aqua">حالة الحساب:</strong>
                                    <span class="badge bg-{{ Auth::user()->is_active ? 'success' : 'secondary' }} ms-2">
                                        {{ Auth::user()->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong class="text-aqua">تاريخ التسجيل:</strong>
                                    <span class="text-light ms-2">{{ Auth::user()->created_at->format('Y-m-d') }}</span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong class="text-aqua">المنتجات:</strong>
                                    <span class="text-light ms-2">{{ Auth::user()->products->count() }} / {{ Auth::user()->product_limit }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-aqua">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <div>
                                <a href="{{ route('change-password') }}" class="btn btn-warning me-2">
                                    <i class="fas fa-key me-2"></i>تغيير كلمة المرور
                                </a>
                                <button type="submit" class="btn btn-gold">
                                    <i class="fas fa-save me-2"></i>حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // معاينة صورة الملف الشخصي
    const avatarInput = document.getElementById('avatar');
    const avatarImage = document.querySelector('.user-profile-image');
    
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // معاينة شعار المتجر (للتجار فقط)
    @if(Auth::user()->user_type === 'merchant')
    const storeLogoInput = document.getElementById('store_logo');
    const storeLogoImage = document.querySelector('.store-logo-image');
    
    storeLogoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                storeLogoImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
    @endif
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

.user-profile-image, .store-logo-image {
    transition: all 0.3s ease;
}

.user-profile-image:hover, .store-logo-image:hover {
    transform: scale(1.05);
}

.btn-aqua {
    background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
    border: none;
    color: #000;
    font-weight: 600;
}

.btn-aqua:hover {
    background: linear-gradient(135deg, var(--aqua-secondary), var(--aqua-primary));
    color: #000;
}
</style>
@endsection
