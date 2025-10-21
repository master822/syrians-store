@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <div class="card-header bg-primary text-white text-center py-3 mb-4">
                    <h3 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة منتج جديد
                    </h3>
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6>يوجد أخطاء في البيانات:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('add.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @auth
                        @if(Auth::user()->user_type === 'merchant')
                            <input type="hidden" name="is_used" value="0">
                        @else
                            <input type="hidden" name="is_used" value="1">
                        @endif
                    @endauth
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control form-control-lg" 
                               value="{{ old('name') }}" required placeholder="أدخل اسم المنتج">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">وصف المنتج *</label>
                        <textarea name="description" class="form-control" rows="4" 
                                  required placeholder="أدخل وصف مفصل للمنتج">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">السعر (ر.س) *</label>
                            <input type="number" name="price" class="form-control" 
                                   step="0.01" min="0" value="{{ old('price') }}" required 
                                   placeholder="0.00">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">التصنيف *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">اختر التصنيف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    @auth
                        @if(Auth::user()->user_type === 'user')
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">حالة المنتج *</label>
                                <select name="condition" class="form-select" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="جديدة" {{ old('condition') == 'جديدة' ? 'selected' : '' }}>جديدة</option>
                                    <option value="جيدة جداً" {{ old('condition') == 'جيدة جداً' ? 'selected' : '' }}>جيدة جداً</option>
                                    <option value="جيدة" {{ old('condition') == 'جيدة' ? 'selected' : '' }}>جيدة</option>
                                    <option value="متوسطة" {{ old('condition') == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="تحتاج إصلاح" {{ old('condition') == 'تحتاج إصلاح' ? 'selected' : '' }}>تحتاج إصلاح</option>
                                </select>
                            </div>
                        @endif
                    @endauth
                    
                    <div class="mb-4">
                        <label class="form-label text-dark fw-bold">صور المنتج</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <div class="form-text">
                            يمكنك رفع أكثر من صورة للمنتج (الحد الأقصى: 5 صور، الحجم: 2MB لكل صورة)
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-save me-2"></i>إضافة المنتج
                        </button>
                        <a href="{{ route('merchant.products') }}" class="btn btn-outline-secondary py-3">
                            <i class="fas fa-arrow-right me-2"></i>العودة إلى المنتجات
                        </a>
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

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
}

.alert {
    border-radius: 12px;
    border: none;
}
</style>
@endsection
