@extends('layouts.app')

@section('title', 'إعدادات الموقع - لوحة تحكم المسؤول')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-gold">
                <i class="fas fa-cogs me-2"></i>إعدادات الموقع
            </h1>
            <p class="text-light">إدارة إعدادات الموقع والمظهر العام</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-sliders-h me-2"></i>الإعدادات العامة
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- اسم الموقع -->
                        <div class="mb-4">
                            <label for="site_name" class="form-label text-light">
                                اسم الموقع <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control dark-input" 
                                   id="site_name" name="site_name" 
                                   value="{{ old('site_name', 'متجر التخفيضات') }}" required>
                            <div class="form-text text-muted">
                                الاسم الذي سيظهر في أعلى الموقع وفي عنوان المتصفح
                            </div>
                        </div>

                        <!-- شعار الموقع -->
                        <div class="mb-4">
                            <label for="site_logo" class="form-label text-light">شعار الموقع</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" class="form-control dark-input" 
                                           id="site_logo" name="site_logo" 
                                           accept="image/*">
                                    <div class="form-text text-muted">
                                        الحجم الموصى به: 200x50 بكسل
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="current-logo bg-dark p-3 rounded text-center">
                                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">الشعار الحالي</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- وصف الموقع -->
                        <div class="mb-4">
                            <label for="site_description" class="form-label text-light">وصف الموقع</label>
                            <textarea class="form-control dark-input" 
                                      id="site_description" name="site_description" 
                                      rows="3">{{ old('site_description', 'أفضل منصة لبيع وشراء المنتجات الجديدة والمستعملة') }}</textarea>
                            <div class="form-text text-muted">
                                وصف قصير يظهر في محركات البحث
                            </div>
                        </div>

                        <!-- معلومات التواصل -->
                        <div class="mb-4">
                            <h6 class="text-gold mb-3">معلومات التواصل</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_email" class="form-label text-light">البريد الإلكتروني</label>
                                    <input type="email" class="form-control dark-input" 
                                           id="contact_email" name="contact_email" 
                                           value="{{ old('contact_email', 'info@example.com') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_phone" class="form-label text-light">رقم الهاتف</label>
                                    <input type="text" class="form-control dark-input" 
                                           id="contact_phone" name="contact_phone" 
                                           value="{{ old('contact_phone', '+1234567890') }}">
                                </div>
                            </div>
                        </div>

                        <!-- وسائل التواصل الاجتماعي -->
                        <div class="mb-4">
                            <h6 class="text-gold mb-3">وسائل التواصل الاجتماعي</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="facebook_url" class="form-label text-light">
                                        <i class="fab fa-facebook me-2 text-primary"></i>فيسبوك
                                    </label>
                                    <input type="url" class="form-control dark-input" 
                                           id="facebook_url" name="facebook_url" 
                                           value="{{ old('facebook_url') }}"
                                           placeholder="https://facebook.com/username">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="twitter_url" class="form-label text-light">
                                        <i class="fab fa-twitter me-2 text-info"></i>تويتر
                                    </label>
                                    <input type="url" class="form-control dark-input" 
                                           id="twitter_url" name="twitter_url" 
                                           value="{{ old('twitter_url') }}"
                                           placeholder="https://twitter.com/username">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="instagram_url" class="form-label text-light">
                                        <i class="fab fa-instagram me-2 text-danger"></i>انستغرام
                                    </label>
                                    <input type="url" class="form-control dark-input" 
                                           id="instagram_url" name="instagram_url" 
                                           value="{{ old('instagram_url') }}"
                                           placeholder="https://instagram.com/username">
                                </div>
                            </div>
                        </div>

                        <!-- إعدادات الاشتراكات -->
                        <div class="mb-4">
                            <h6 class="text-gold mb-3">إعدادات الاشتراكات</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="free_product_limit" class="form-label text-light">حد المنتجات المجاني</label>
                                    <input type="number" class="form-control dark-input" 
                                           id="free_product_limit" name="free_product_limit" 
                                           value="{{ old('free_product_limit', 5) }}" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="basic_product_limit" class="form-label text-light">حد المنتجات الأساسي</label>
                                    <input type="number" class="form-control dark-input" 
                                           id="basic_product_limit" name="basic_product_limit" 
                                           value="{{ old('basic_product_limit', 20) }}" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="premium_product_limit" class="form-label text-light">حد المنتجات المميز</label>
                                    <input type="number" class="form-control dark-input" 
                                           id="premium_product_limit" name="premium_product_limit" 
                                           value="{{ old('premium_product_limit', 100) }}" min="1">
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الحفظ -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-aqua">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-save me-2"></i>حفظ الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- معلومات سريعة -->
        <div class="col-lg-4">
            <!-- إحصائيات سريعة -->
            <div class="elite-card mb-4">
                <div class="card-header bg-dark-card py-3">
                    <h6 class="text-gold mb-0">
                        <i class="fas fa-chart-bar me-2"></i>إحصائيات سريعة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-aqua">عدد المستخدمين:</strong>
                        <span class="text-light float-end">1,234</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">عدد المنتجات:</strong>
                        <span class="text-light float-end">5,678</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">عدد الطلبات:</strong>
                        <span class="text-light float-end">2,345</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">الإيرادات الشهرية:</strong>
                        <span class="text-light float-end">150,000 ل.س</span>
                    </div>
                </div>
            </div>

            <!-- نصائح الأمان -->
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h6 class="text-gold mb-0">
                        <i class="fas fa-shield-alt me-2"></i>نصائح الأمان
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تنبيه:</strong> احتفظ بنسخة احتياطية من الإعدادات
                    </div>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            استخدم كلمات مرور قوية
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            حدّث النظام بانتظام
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            راجع الصلاحيات دورياً
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            احتفظ بسجلات النسخ الاحتياطي
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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

.current-logo {
    border: 2px dashed var(--dark-border);
    min-height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.alert-warning {
    background: rgba(255, 193, 7, 0.1);
    border: 1px solid var(--warning);
    color: var(--text-primary);
}
</style>
@endsection
