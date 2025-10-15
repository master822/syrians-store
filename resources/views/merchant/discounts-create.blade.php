@extends('layouts.app')

@section('title', 'إضافة تخفيض جديد - متجر التخفيضات')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-tag me-2"></i>
                        إضافة تخفيض جديد
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('merchant.discounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- اختيار المنتجات -->
                        <div class="mb-4">
                            <label class="form-label text-light">اختر المنتجات <span class="text-danger">*</span></label>
                            <div class="products-grid">
                                @if($products->count() > 0)
                                    @foreach($products as $product)
                                    <div class="product-checkbox-card">
                                        <input type="checkbox" 
                                               name="products[]" 
                                               value="{{ $product->id }}" 
                                               id="product_{{ $product->id }}"
                                               class="product-checkbox"
                                               {{ request('product') == $product->id ? 'checked' : '' }}>
                                        <label for="product_{{ $product->id }}" class="product-label">
                                            <div class="product-image">
                                                @if($product->images)
                                                    @php
                                                        $images = json_decode($product->images);
                                                        $firstImage = $images[0] ?? null;
                                                    @endphp
                                                    @if($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage) }}" 
                                                             alt="{{ $product->name }}">
                                                    @else
                                                        <div class="no-image">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="no-image">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-info">
                                                <h6 class="product-name">{{ $product->name }}</h6>
                                                <p class="product-price">{{ number_format($product->price) }} ل.س</p>
                                                <p class="product-category">
                                                    <small>{{ $product->category->name ?? 'غير محدد' }}</small>
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">لا توجد منتجات متاحة للتخفيض</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-gold">
                                            إضافة منتج جديد
                                        </a>
                                    </div>
                                @endif
                            </div>
                            @error('products')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- نسبة التخفيض -->
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label text-light">
                                نسبة التخفيض (%) <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control dark-input" 
                                   id="discount_percentage" name="discount_percentage" 
                                   min="1" max="90" value="{{ old('discount_percentage', 10) }}" required>
                            <div class="form-text text-muted">
                                أدخل نسبة التخفيض من 1% إلى 90%
                            </div>
                            @error('discount_percentage')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- مدة التخفيض -->
                        <div class="mb-3">
                            <label for="discount_duration" class="form-label text-light">
                                مدة التخفيض (أيام) <span class="text-danger">*</span>
                            </label>
                            <select class="form-control dark-input" id="discount_duration" name="discount_duration" required>
                                <option value="1" {{ old('discount_duration') == 1 ? 'selected' : '' }}>1 يوم</option>
                                <option value="3" {{ old('discount_duration') == 3 ? 'selected' : '' }}>3 أيام</option>
                                <option value="7" {{ old('discount_duration') == 7 ? 'selected' : '' }}>أسبوع</option>
                                <option value="15" {{ old('discount_duration') == 15 ? 'selected' : '' }}>15 يوم</option>
                                <option value="30" {{ old('discount_duration') == 30 ? 'selected' : '' }}>شهر</option>
                                <option value="0" {{ old('discount_duration') == 0 ? 'selected' : '' }}>غير محدد</option>
                            </select>
                            @error('discount_duration')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- صور التخفيض -->
                        <div class="mb-4">
                            <label for="discount_images" class="form-label text-light">صور التخفيض (اختياري)</label>
                            <input type="file" class="form-control dark-input" 
                                   id="discount_images" name="discount_images[]" 
                                   multiple accept="image/*">
                            <div class="form-text text-muted">
                                يمكنك رفع صور خاصة بالتخفيض (اختياري)
                            </div>
                            @error('discount_images.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معاينة التخفيض -->
                        <div class="mb-4 preview-section" style="display: none;">
                            <h6 class="text-gold mb-3">معاينة التخفيض:</h6>
                            <div class="preview-card elite-card p-3">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <div class="preview-image bg-dark rounded text-center py-4">
                                            <i class="fas fa-tag fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-light mb-1">تخفيض خاص</h6>
                                        <p class="text-muted mb-1">سيتم تطبيق الخصم على <span class="selected-count">0</span> منتج</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-danger fw-bold discount-preview">0%</span>
                                            <span class="badge bg-info duration-preview">0 يوم</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات مهمة -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>معلومات مهمة:</h6>
                            <ul class="mb-0">
                                <li>يمكنك اختيار أكثر من منتج لتطبيق نفس نسبة التخفيض عليها</li>
                                <li>التخفيض يزيد من فرص ظهور منتجاتك للعملاء</li>
                                <li>يمكنك تعديل أو إزالة التخفيض في أي وقت</li>
                                <li>يجب أن تكون المنتجات نشطة لتطبيق التخفيض</li>
                            </ul>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('merchant.discounts') }}" class="btn btn-outline-aqua">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <button type="submit" class="btn btn-gold" id="submitBtn" {{ $products->count() == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-tag me-2"></i>تطبيق التخفيض
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const discountPercentage = document.getElementById('discount_percentage');
    const discountDuration = document.getElementById('discount_duration');
    const previewSection = document.querySelector('.preview-section');
    const selectedCount = document.querySelector('.selected-count');
    const discountPreview = document.querySelector('.discount-preview');
    const durationPreview = document.querySelector('.duration-preview');
    const submitBtn = document.getElementById('submitBtn');

    function updatePreview() {
        const selectedProducts = document.querySelectorAll('.product-checkbox:checked').length;
        const percentage = discountPercentage.value;
        const duration = discountDuration.options[discountDuration.selectedIndex].text;
        
        if (selectedProducts > 0 && percentage > 0) {
            previewSection.style.display = 'block';
            selectedCount.textContent = selectedProducts;
            discountPreview.textContent = percentage + '%';
            durationPreview.textContent = duration;
            submitBtn.disabled = false;
        } else {
            previewSection.style.display = 'none';
            submitBtn.disabled = selectedProducts === 0;
        }
    }

    // تحديث المعاينة عند تغيير الاختيارات
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePreview);
    });

    discountPercentage.addEventListener('input', updatePreview);
    discountDuration.addEventListener('change', updatePreview);

    // التهيئة الأولية
    updatePreview();
});
</script>

<style>
.dark-input {
    background: var(--dark-surface);
    border: 1px solid var(--dark-border);
    color: var(--text-primary);
}

.dark-input:focus {
    background: var(--dark-surface);
    border-color: var(--gold-primary);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid var(--dark-border);
    border-radius: 8px;
    background: var(--dark-surface);
}

.product-checkbox-card {
    position: relative;
}

.product-checkbox {
    display: none;
}

.product-checkbox:checked + .product-label {
    border-color: var(--gold-primary);
    background: rgba(212, 175, 55, 0.1);
}

.product-label {
    display: block;
    border: 2px solid var(--dark-border);
    border-radius: 8px;
    padding: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: var(--dark-card);
}

.product-label:hover {
    border-color: var(--aqua-primary);
}

.product-image {
    width: 100%;
    height: 100px;
    overflow: hidden;
    border-radius: 5px;
    margin-bottom: 10px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--dark-surface);
    color: var(--text-secondary);
}

.product-info {
    text-align: center;
}

.product-name {
    color: var(--text-primary);
    font-size: 0.9rem;
    margin-bottom: 5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.product-price {
    color: var(--aqua-primary);
    font-weight: bold;
    margin-bottom: 5px;
}

.product-category {
    color: var(--text-secondary);
    font-size: 0.8rem;
    margin-bottom: 0;
}

.preview-card {
    border: 2px solid var(--gold-primary);
}

.alert-info {
    background: rgba(32, 201, 151, 0.1);
    border: 1px solid var(--aqua-primary);
    color: var(--text-primary);
}
</style>
@endsection
