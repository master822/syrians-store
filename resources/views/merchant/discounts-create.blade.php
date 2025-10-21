@extends('layouts.app')

@section('title', 'إنشاء تخفيض جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">إنشاء تخفيض جديد</h4>
                
                @if($products->count() > 0)
                <form action="{{ route('merchant.discounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- اختيار المنتجات -->
                    <div class="mb-3">
                        <label class="form-label text-dark">اختر المنتجات *</label>
                        <div class="products-grid">
                            @foreach($products as $product)
                            <div class="product-checkbox-item">
                                <input type="checkbox" name="products[]" value="{{ $product->id }}" 
                                       id="product_{{ $product->id }}" class="form-check-input">
                                <label for="product_{{ $product->id }}" class="form-check-label">
                                    <div class="product-info">
                                        <strong>{{ $product->name }}</strong>
                                        <span class="price">{{ number_format($product->price, 2) }} ر.س</span>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('products')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- نسبة التخفيض -->
                    <div class="mb-3">
                        <label class="form-label text-dark">نسبة التخفيض *</label>
                        <input type="number" name="discount_percentage" class="form-control" 
                               min="1" max="100" required value="{{ old('discount_percentage') }}"
                               placeholder="أدخل نسبة التخفيض من 1% إلى 100%">
                        @error('discount_percentage')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- مدة التخفيض -->
                    <div class="mb-3">
                        <label class="form-label text-dark">مدة التخفيض (أيام)</label>
                        <input type="number" name="discount_duration" class="form-control" 
                               min="0" value="{{ old('discount_duration', 7) }}"
                               placeholder="اتركه 0 للتخفيض الدائم">
                        <small class="text-muted">اتركه 0 للتخفيض الدائم</small>
                    </div>
                    
                    <!-- صور التخفيض -->
                    <div class="mb-3">
                        <label class="form-label text-dark">صور التخفيض (اختياري)</label>
                        <input type="file" name="discount_images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">يمكنك رفع حتى 3 صور</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">تطبيق التخفيض</button>
                        <a href="{{ route('merchant.discounts') }}" class="btn btn-outline-secondary">إلغاء</a>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-dark">لا توجد منتجات متاحة</h5>
                    <p class="text-muted">يجب أن تضيف منتجات أولاً قبل إنشاء تخفيضات</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">إضافة منتج جديد</a>
                </div>
                @endif
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

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 10px;
}

.product-checkbox-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border: 1px solid #e9ecef;
    border-radius: 5px;
    transition: background-color 0.2s;
}

.product-checkbox-item:hover {
    background-color: #f8f9fa;
}

.product-checkbox-item input[type="checkbox"] {
    margin-right: 10px;
}

.product-info {
    display: flex;
    flex-direction: column;
}

.product-info .price {
    color: #28a745;
    font-weight: bold;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="products[]"]');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    function checkSelection() {
        const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        submitBtn.disabled = !checked;
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', checkSelection);
    });
    
    // التحقق الأولي
    checkSelection();
});
</script>
@endsection
