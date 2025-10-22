@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">إضافة منتج جديد</h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">اسم المنتج</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">التصنيف</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">اختر التصنيف</option>
                                        <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>ملابس</option>
                                        <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                                        <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                                        <option value="grocery" {{ old('category') == 'grocery' ? 'selected' : '' }}>بقالة</option>
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">السعر (TL)</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="{{ old('price') }}" min="0" step="0.01" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="stock" class="form-label">الكمية المتاحة</label>
                                    <input type="number" class="form-control" id="stock" name="stock" 
                                           value="{{ old('stock', 1) }}" min="1" required>
                                    @error('stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">وصف المنتج</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="images" class="form-label">صور المنتج (يمكن رفع حتى 6 صور)</label>
                            <input type="file" class="form-control" id="images" name="images[]" 
                                   multiple accept="image/*">
                            @error('images.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="discount_percentage" class="form-label">نسبة التخفيض (%) - اختياري</label>
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" 
                                   value="{{ old('discount_percentage', 0) }}" min="0" max="100" step="0.1">
                            @error('discount_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                            <a href="{{ route('merchant.dashboard') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
