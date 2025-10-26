@extends('layouts.app')

@section('title', 'إعدادات الموقع - المسؤول')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-primary">إعدادات الموقع</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-primary mb-3">المعلومات الأساسية</h4>
                        
                        <div class="mb-3">
                            <label class="form-label">اسم الموقع</label>
                            <input type="text" name="site_name" class="form-control" value="{{ config('app.name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">شعار الموقع</label>
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            <small class="text-muted">الصيغ المسموحة: JPEG, PNG, JPG, GIF - الحجم الأقصى: 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">وصف الموقع</label>
                            <textarea name="site_description" class="form-control" rows="3" placeholder="وصف مختصر عن الموقع..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="text-primary mb-3">معلومات التواصل</h4>
                        
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني للتواصل</label>
                            <input type="email" name="contact_email" class="form-control" placeholder="info@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="contact_phone" class="form-control" placeholder="+90 555 123 4567">
                        </div>

                        <h4 class="text-primary mb-3 mt-4">وسائل التواصل الاجتماعي</h4>
                        
                        <div class="mb-3">
                            <label class="form-label">فيسبوك</label>
                            <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/username">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">تويتر</label>
                            <input type="url" name="twitter_url" class="form-control" placeholder="https://twitter.com/username">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">إنستغرام</label>
                            <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/username">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            سيتم تطبيق التغييرات فور حفظ الإعدادات
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1rem;
}
</style>
@endsection
