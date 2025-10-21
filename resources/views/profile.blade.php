@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">الملف الشخصي</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">رقم الهاتف *</label>
                        <input type="text" name="phone" class="form-control" 
                               value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">البلد *</label>
                        <select name="city" class="form-select" required>
                            <option value="">اختر البلد</option>
                            <option value="السعودية" {{ old('city', $user->city) == 'السعودية' ? 'selected' : '' }}>السعودية</option>
                            <option value="الإمارات" {{ old('city', $user->city) == 'الإمارات' ? 'selected' : '' }}>الإمارات</option>
                            <option value="قطر" {{ old('city', $user->city) == 'قطر' ? 'selected' : '' }}>قطر</option>
                            <option value="الكويت" {{ old('city', $user->city) == 'الكويت' ? 'selected' : '' }}>الكويت</option>
                            <option value="البحرين" {{ old('city', $user->city) == 'البحرين' ? 'selected' : '' }}>البحرين</option>
                            <option value="عمان" {{ old('city', $user->city) == 'عمان' ? 'selected' : '' }}>عمان</option>
                            <option value="تركيا" {{ old('city', $user->city) == 'تركيا' ? 'selected' : '' }}>تركيا</option>
                            <option value="مصر" {{ old('city', $user->city) == 'مصر' ? 'selected' : '' }}>مصر</option>
                            <option value="الأردن" {{ old('city', $user->city) == 'الأردن' ? 'selected' : '' }}>الأردن</option>
                            <option value="لبنان" {{ old('city', $user->city) == 'لبنان' ? 'selected' : '' }}>لبنان</option>
                            <option value="العراق" {{ old('city', $user->city) == 'العراق' ? 'selected' : '' }}>العراق</option>
                            <option value="سوريا" {{ old('city', $user->city) == 'سوريا' ? 'selected' : '' }}>سوريا</option>
                            <option value="اليمن" {{ old('city', $user->city) == 'اليمن' ? 'selected' : '' }}>اليمن</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">صورة الملف الشخصي</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                        <small class="text-muted">اختر صورة لملفك الشخصي (اختياري)</small>
                    </div>
                    
                    @if($user->isMerchant())
                    <hr class="my-4">
                    <h5 class="text-dark mb-3">معلومات المتجر</h5>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">اسم المتجر *</label>
                        <input type="text" name="store_name" class="form-control" 
                               value="{{ old('store_name', $user->store_name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">فئة المتجر *</label>
                        <select name="store_category" class="form-select" required>
                            <option value="">اختر فئة المتجر</option>
                            <option value="electronics" {{ old('store_category', $user->store_category) == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                            <option value="clothes" {{ old('store_category', $user->store_category) == 'clothes' ? 'selected' : '' }}>ملابس</option>
                            <option value="home" {{ old('store_category', $user->store_category) == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                            <option value="grocery" {{ old('store_category', $user->store_category) == 'grocery' ? 'selected' : '' }}>بقالة</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">وصف المتجر *</label>
                        <textarea name="store_description" class="form-control" rows="3" required>{{ old('store_description', $user->store_description) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">هاتف المتجر *</label>
                        <input type="text" name="store_phone" class="form-control" 
                               value="{{ old('store_phone', $user->store_phone) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">مدينة المتجر *</label>
                        <input type="text" name="store_city" class="form-control" 
                               value="{{ old('store_city', $user->store_city) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">شعار المتجر</label>
                        <input type="file" name="store_logo" class="form-control" accept="image/*">
                        <small class="text-muted">اختر شعاراً لمتجرك (اختياري)</small>
                    </div>
                    @endif
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">تحديث الملف الشخصي</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
