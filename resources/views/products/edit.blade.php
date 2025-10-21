@extends('layouts.app')

@section('title', 'تعديل المنتج - ' . $product->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <div class="card-header bg-warning text-dark text-center py-3 mb-4">
                    <h3 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        تعديل المنتج: {{ $product->name }}
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
                
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- الحقول المخفية المطلوبة -->
                    <input type="hidden" name="is_used" value="{{ $product->is_used ? '1' : '0' }}">
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control form-control-lg" 
                               value="{{ old('name', $product->name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">وصف المنتج *</label>
                        <textarea name="description" class="form-control" rows="5" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">السعر (ر.س) *</label>
                            <input type="number" name="price" class="form-control" 
                                   step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">التصنيف *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">اختر التصنيف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- نوع المنتج (للإظهار فقط) -->
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">نوع المنتج</label>
                        <div class="form-control bg-light">
                            @if($product->is_used)
                                <span class="badge bg-info fs-6">🔄 منتج مستعمل</span>
                            @else
                                <span class="badge bg-success fs-6">🆕 منتج جديد</span>
                            @endif
                            <small class="text-muted d-block mt-1">لا يمكن تغيير نوع المنتج بعد الإنشاء</small>
                        </div>
                    </div>
                    
                    @if($product->is_used)
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">حالة المنتج *</label>
                        <select name="condition" class="form-select" required>
                            <option value="">اختر الحالة</option>
                            <option value="جديدة" {{ old('condition', $product->condition) == 'جديدة' ? 'selected' : '' }}>🆕 جديدة</option>
                            <option value="جيدة جداً" {{ old('condition', $product->condition) == 'جيدة جداً' ? 'selected' : '' }}>⭐ جيدة جداً</option>
                            <option value="جيدة" {{ old('condition', $product->condition) == 'جيدة' ? 'selected' : '' }}>👍 جيدة</option>
                            <option value="متوسطة" {{ old('condition', $product->condition) == 'متوسطة' ? 'selected' : '' }}>🔄 متوسطة</option>
                            <option value="تحتاج إصلاح" {{ old('condition', $product->condition) == 'تحتاج إصلاح' ? 'selected' : '' }}>🔧 تحتاج إصلاح</option>
                        </select>
                    </div>
                    @else
                        <input type="hidden" name="condition" value="">
                    @endif
                    
                    <div class="mb-4">
                        <label class="form-label text-dark fw-bold">صور المنتج الحالية</label>
                        @if($product->images)
                            @php
                                $images = json_decode($product->images);
                            @endphp
                            <div class="row mb-3">
                                @foreach($images as $image)
                                    <div class="col-3 mb-2">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="height: 80px; object-fit: cover;">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image }}" id="delete_{{ $loop->index }}">
                                            <label class="form-check-label small" for="delete_{{ $loop->index }}">حذف</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">لا توجد صور للمنتج</p>
                        @endif
                        
                        <label class="form-label text-dark fw-bold">إضافة صور جديدة</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <div class="form-text">
                            يمكنك رفع صور جديدة أو حذف الصور الحالية
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg py-3">
                            <i class="fas fa-save me-2"></i>تحديث المنتج
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
    border-color: #f59e0b;
    box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    color: white;
}

.alert {
    border-radius: 12px;
    border: none;
}

.img-thumbnail {
    border-radius: 8px;
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection
