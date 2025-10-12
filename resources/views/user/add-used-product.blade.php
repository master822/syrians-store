@extends('layouts.app')

@section('title', 'إضافة منتج مستعمل')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="animated-card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-recycle me-2"></i>إضافة منتج مستعمل</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.used-products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">اسم المنتج</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">السعر (ر.س)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                       value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">الفئة</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">اختر الفئة</option>
                                    <option value="clothes" {{ old('category') == 'clothes' ? 'selected' : '' }}>👕 ملابس</option>
                                    <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>📱 إلكترونيات</option>
                                    <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>🏠 أدوات منزلية</option>
                                    <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>🍎 بقالة</option>
                                </select>
                                @error('category')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="condition" class="form-label">حالة المنتج</label>
                                <select class="form-select" id="condition" name="condition" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="جديد" {{ old('condition') == 'جديد' ? 'selected' : '' }}>🆕 جديد</option>
                                    <option value="جيد جدا" {{ old('condition') == 'جيد جدا' ? 'selected' : '' }}>⭐ جيد جداً</option>
                                    <option value="جيد" {{ old('condition') == 'جيد' ? 'selected' : '' }}>👍 جيد</option>
                                    <option value="متوسط" {{ old('condition') == 'متوسط' ? 'selected' : '' }}>➖ متوسط</option>
                                </select>
                                @error('condition')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المنتج</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="صف المنتج المستعمل بالتفصيل..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_images" class="form-label">صور المنتج (اختياري)</label>
                            <input type="file" class="form-control" id="product_images" name="product_images[]" multiple accept="image/*">
                            <div class="form-text">يمكنك رفع حتى 3 صور. الصيغ المدعومة: JPEG, PNG, JPG, GIF</div>
                            @error('product_images.*')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url('/user/my-products') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-1"></i>رجوع
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i>إضافة المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
