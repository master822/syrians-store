@extends('layouts.app')

@section('title', 'تعديل منتج مستعمل')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="animated-card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>تعديل منتج مستعمل</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.used-products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">اسم المنتج</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">السعر (ر.س)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $product->price) }}" required>
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
                                    <option value="clothes" {{ old('category', $product->category) == 'clothes' ? 'selected' : '' }}>👕 ملابس</option>
                                    <option value="electronics" {{ old('category', $product->category) == 'electronics' ? 'selected' : '' }}>📱 إلكترونيات</option>
                                    <option value="home" {{ old('category', $product->category) == 'home' ? 'selected' : '' }}>🏠 أدوات منزلية</option>
                                    <option value="food" {{ old('category', $product->category) == 'food' ? 'selected' : '' }}>🍎 بقالة</option>
                                </select>
                                @error('category')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="condition" class="form-label">حالة المنتج</label>
                                <select class="form-select" id="condition" name="condition" required>
                                    <option value="">اختر الحالة</option>
                                    <option value="جديد" {{ str_contains($product->description, 'جديد') ? 'selected' : '' }}>🆕 جديد</option>
                                    <option value="جيد جدا" {{ str_contains($product->description, 'جيد جدا') ? 'selected' : '' }}>⭐ جيد جداً</option>
                                    <option value="جيد" {{ str_contains($product->description, 'جيد') ? 'selected' : '' }}>👍 جيد</option>
                                    <option value="متوسط" {{ str_contains($product->description, 'متوسط') ? 'selected' : '' }}>➖ متوسط</option>
                                </select>
                                @error('condition')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المنتج</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="صف المنتج المستعمل بالتفصيل..." required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الصور الحالية -->
                        @if($product->discount_images)
                            @php
                                $images = json_decode($product->discount_images, true);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">الصور الحالية</label>
                                <div class="row">
                                    @foreach($images as $index => $image)
                                        <div class="col-md-4 mb-2">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover;">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image }}" id="deleteImage{{ $index }}">
                                                    <label class="form-check-label text-danger small" for="deleteImage{{ $index }}">
                                                        حذف الصورة
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- إضافة صور جديدة -->
                        <div class="mb-3">
                            <label for="product_images" class="form-label">إضافة صور جديدة (اختياري)</label>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
