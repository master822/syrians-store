@extends('layouts.app')

@section('title', 'إضافة منتج مستعمل')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">إضافة منتج مستعمل</h4>
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="is_used" value="1">
                    
                    <!-- اسم المنتج -->
                    <div class="mb-3">
                        <label class="form-label text-dark">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- وصف المنتج -->
                    <div class="mb-3">
                        <label class="form-label text-dark">وصف المنتج *</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- السعر -->
                    <div class="mb-3">
                        <label class="form-label text-dark">السعر (ر.س) *</label>
                        <input type="number" name="price" class="form-control" 
                               step="0.01" min="0" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- التصنيف -->
                    <div class="mb-3">
                        <label class="form-label text-dark">التصنيف *</label>
                        <select name="category_id" class="form-select" required>
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
                    
                    <!-- حالة المنتج -->
                    <div class="mb-3">
                        <label class="form-label text-dark">حالة المنتج *</label>
                        <select name="condition" class="form-select" required>
                            <option value="">اختر الحالة</option>
                            <option value="جديد" {{ old('condition') == 'جديد' ? 'selected' : '' }}>جديد</option>
                            <option value="جيد جداً" {{ old('condition') == 'جيد جداً' ? 'selected' : '' }}>جيد جداً</option>
                            <option value="جيد" {{ old('condition') == 'جيد' ? 'selected' : '' }}>جيد</option>
                            <option value="مقبول" {{ old('condition') == 'مقبول' ? 'selected' : '' }}>مقبول</option>
                            <option value="بحاجة لإصلاح" {{ old('condition') == 'بحاجة لإصلاح' ? 'selected' : '' }}>بحاجة لإصلاح</option>
                        </select>
                        @error('condition')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- صور المنتج -->
                    <div class="mb-3">
                        <label class="form-label text-dark">صور المنتج *</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                        <small class="text-muted">يمكنك رفع حتى 5 صور للمنتج</small>
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                        <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
@endsection
