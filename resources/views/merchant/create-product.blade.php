@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم المنتج *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المنتج *</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">السعر (TL) *</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   value="{{ old('price') }}" min="0" step="0.01" required>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">التصنيف *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">اختر التصنيف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">صور المنتج</label>
                            <input type="file" class="form-control" id="images" name="images[]" 
                                   multiple accept="image/*">
                            <div class="form-text">
                                يمكنك رفع أكثر من صورة للمنتج (الحد الأقصى: 5 صور)
                            </div>
                            @error('images.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقل مخفي للمنتجات الجديدة -->
                        <input type="hidden" name="is_used" value="0">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('merchant.products') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>رجوع
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>إضافة المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
