@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">➕ إضافة منتج جديد</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/merchant/products" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">وصف المنتج</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر (ر.س)</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">الفئة</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">اختر الفئة</option>
                                    <option value="clothes" {{ old('category') == 'clothes' ? 'selected' : '' }}>👕 ملابس</option>
                                    <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>📱 إلكترونيات</option>
                                    <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>🏠 أدوات منزلية</option>
                                    <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>🍎 بقالة</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="discount_id" class="form-label">تخفيض (اختياري)</label>
                        <select class="form-select @error('discount_id') is-invalid @enderror" 
                                id="discount_id" name="discount_id">
                            <option value="">بدون تخفيض</option>
                            @foreach($discounts as $discount)
                                <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                    {{ $discount->name }} ({{ $discount->percentage }}%)
                                </option>
                            @endforeach
                        </select>
                        @error('discount_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">صور المنتج (حتى 5 صور)</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*" required>
                        <div class="form-text">يمكنك رفع حتى 5 صور للمنتج</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                        <a href="/merchant/products" class="btn btn-secondary">العودة إلى المنتجات</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
