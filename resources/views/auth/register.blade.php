@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="elite-card p-5">
                <div class="text-center mb-5">
                    <h2 class="text-gold mb-3">إنشاء حساب جديد</h2>
                    <p class="text-light">انضم إلى منصتنا اليوم!</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label text-light mb-3">الاسم الكامل</label>
                            <input type="text" class="form-control py-3 px-4 @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="أدخل اسمك الكامل">
                            @error('name')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label text-light mb-3">البريد الإلكتروني</label>
                            <input type="email" class="form-control py-3 px-4 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="أدخل بريدك الإلكتروني">
                            @error('email')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="phone" class="form-label text-light mb-3">رقم الهاتف</label>
                            <input type="text" class="form-control py-3 px-4 @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required
                                   placeholder="أدخل رقم هاتفك">
                            @error('phone')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="country" class="form-label text-light mb-3">الدولة</label>
                            <select class="form-select py-3 px-4 @error('country') is-invalid @enderror" 
                                    id="country" name="country" required>
                                <option value="">اختر الدولة</option>
                                <option value="saudi" {{ old('country') == 'saudi' ? 'selected' : '' }}>🇸🇦 السعودية</option>
                                <option value="uae" {{ old('country') == 'uae' ? 'selected' : '' }}>🇦🇪 الإمارات</option>
                                <option value="egypt" {{ old('country') == 'egypt' ? 'selected' : '' }}>🇪🇬 مصر</option>
                                <option value="jordan" {{ old('country') == 'jordan' ? 'selected' : '' }}>🇯🇴 الأردن</option>
                                <option value="lebanon" {{ old('country') == 'lebanon' ? 'selected' : '' }}>🇱🇧 لبنان</option>
                                <option value="syria" {{ old('country') == 'syria' ? 'selected' : '' }}>🇸🇾 سوريا</option>
                                <option value="iraq" {{ old('country') == 'iraq' ? 'selected' : '' }}>🇮🇶 العراق</option>
                                <option value="qatar" {{ old('country') == 'qatar' ? 'selected' : '' }}>🇶🇦 قطر</option>
                                <option value="kuwait" {{ old('country') == 'kuwait' ? 'selected' : '' }}>🇰🇼 الكويت</option>
                                <option value="oman" {{ old('country') == 'oman' ? 'selected' : '' }}>🇴🇲 عمان</option>
                                <option value="bahrain" {{ old('country') == 'bahrain' ? 'selected' : '' }}>🇧🇭 البحرين</option>
                            </select>
                            @error('country')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="city" class="form-label text-light mb-3">المدينة</label>
                            <select class="form-select py-3 px-4 @error('city') is-invalid @enderror" 
                                    id="city" name="city" required>
                                <option value="">اختر الدولة أولاً</option>
                            </select>
                            @error('city')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label text-light mb-3">كلمة المرور</label>
                            <input type="password" class="form-control py-3 px-4 @error('password') is-invalid @enderror" 
                                   id="password" name="password" required
                                   placeholder="أنشئ كلمة مرور قوية">
                            @error('password')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label text-light mb-3">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control py-3 px-4" 
                                   id="password_confirmation" name="password_confirmation" required
                                   placeholder="أعد إدخال كلمة المرور">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="user_type" class="form-label text-light mb-3">نوع الحساب</label>
                            <select class="form-select py-3 px-4 @error('user_type') is-invalid @enderror" 
                                    id="user_type" name="user_type" required>
                                <option value="">اختر نوع الحساب</option>
                                <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                                <option value="merchant" {{ old('user_type') == 'merchant' ? 'selected' : '' }}>تاجر</option>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback d-block text-red-accent">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- حقول التاجر -->
                    <div id="merchant_fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="store_name" class="form-label text-light mb-3">اسم المتجر</label>
                                <input type="text" class="form-control py-3 px-4" 
                                       id="store_name" name="store_name" value="{{ old('store_name') }}"
                                       placeholder="اسم متجرك">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="store_category" class="form-label text-light mb-3">تصنيف المتجر</label>
                                <select class="form-select py-3 px-4" id="store_category" name="store_category">
                                    <option value="">اختر التصنيف</option>
                                    <option value="clothes" {{ old('store_category') == 'clothes' ? 'selected' : '' }}>ملابس</option>
                                    <option value="electronics" {{ old('store_category') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                    <option value="home" {{ old('store_category') == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                                    <option value="grocery" {{ old('store_category') == 'grocery' ? 'selected' : '' }}>بقالة</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="store_description" class="form-label text-light mb-3">وصف المتجر</label>
                            <textarea class="form-control py-3 px-4" id="store_description" 
                                      name="store_description" rows="3" placeholder="صف متجرك">{{ old('store_description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="store_phone" class="form-label text-light mb-3">هاتف المتجر</label>
                                <input type="text" class="form-control py-3 px-4" 
                                       id="store_phone" name="store_phone" value="{{ old('store_phone') }}"
                                       placeholder="هاتف المتجر">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="store_city" class="form-label text-light mb-3">مدينة المتجر</label>
                                <input type="text" class="form-control py-3 px-4" 
                                       id="store_city" name="store_city" value="{{ old('store_city') }}"
                                       placeholder="مدينة المتجر">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn-gold py-3 fs-5">
                            إنشاء الحساب
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-light mb-0">لديك حساب بالفعل؟ 
                        <a href="{{ route('login') }}" class="text-aqua text-decoration-none fw-bold">تسجيل الدخول</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// بيانات المدن لكل دولة
const citiesData = {
    saudi: ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الطائف', 'تبوك'],
    uae: ['دبي', 'أبوظبي', 'الشارقة', 'عجمان', 'العين', 'رأس الخيمة', 'الفجيرة'],
    egypt: ['القاهرة', 'الإسكندرية', 'الجيزة', 'شبرا', 'المحلة', 'بورسعيد', 'السويس'],
    jordan: ['عمان', 'الزرقاء', 'إربد', 'العقبة', 'الكرك', 'مادبا', 'السلط'],
    lebanon: ['بيروت', 'طرابلس', 'صيدا', 'صور', 'زحلة', 'جبيل', 'بعبدا'],
    syria: ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'دير الزور'],
    iraq: ['بغداد', 'البصرة', 'الموصل', 'أربيل', 'كركوك', 'الناصرية', 'الكوت'],
    qatar: ['الدوحة', 'الريان', 'أم صلال', 'الخور', 'الوكرة', 'الشحانية'],
    kuwait: ['الكويت', 'حولي', 'الفروانية', 'الأحمدي', 'الجهراء', 'مبارك'],
    oman: ['مسقط', 'صلالة', 'صحار', 'نزوى', 'صور', 'بهلا', 'الرستاق'],
    bahrain: ['المنامة', 'المحرق', 'الرفاع', 'مدينة حمد', 'الحد', 'سترة']
};

document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country');
    const citySelect = document.getElementById('city');
    const userTypeSelect = document.getElementById('user_type');
    const merchantFields = document.getElementById('merchant_fields');

    // تحديث المدن عند تغيير الدولة
    countrySelect.addEventListener('change', function() {
        const selectedCountry = this.value;
        citySelect.innerHTML = '<option value="">اختر المدينة</option>';
        
        if (selectedCountry && citiesData[selectedCountry]) {
            citiesData[selectedCountry].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    });

    // تبديل حقول التاجر
    function toggleMerchantFields() {
        if (userTypeSelect.value === 'merchant') {
            merchantFields.style.display = 'block';
        } else {
            merchantFields.style.display = 'none';
        }
    }

    userTypeSelect.addEventListener('change', toggleMerchantFields);
    toggleMerchantFields(); // التهيئة الأولية

    // تهيئة المدن إذا كانت الدولة محددة مسبقاً
    if (countrySelect.value) {
        countrySelect.dispatchEvent(new Event('change'));
    }
});
</script>

<style>
    .text-red-accent {
        color: var(--red-accent) !important;
    }
</style>
@endsection
