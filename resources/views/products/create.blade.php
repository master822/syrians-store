@extends('layouts.app')

@section('title', 'إضافة منتج جديد - متجر التخفيضات')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        @if(Auth::user()->user_type === 'merchant')
                            إضافة منتج جديد
                        @else
                            إضافة منتج مستعمل
                        @endif
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- اسم المنتج -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-light">اسم المنتج <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dark-input" id="name" name="name" 
                                       value="{{ old('name') }}" required placeholder="أدخل اسم المنتج">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- السعر -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label text-light">السعر (ليرة سورية) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control dark-input" id="price" name="price" 
                                       step="100" min="0" value="{{ old('price') }}" required placeholder="أدخل السعر">
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- الوصف -->
                        <div class="mb-3">
                            <label for="description" class="form-label text-light">وصف المنتج <span class="text-danger">*</span></label>
                            <textarea class="form-control dark-input" id="description" name="description" 
                                      rows="4" required placeholder="أدخل وصفاً مفصلاً للمنتج">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- التصنيف -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label text-light">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-control dark-input" id="category_id" name="category_id" required>
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

                        <!-- نوع المنتج -->
                        <div class="mb-3">
                            <label class="form-label text-light">نوع المنتج <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                @if(Auth::user()->user_type === 'merchant')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_used" id="new_product" 
                                               value="0" checked>
                                        <label class="form-check-label text-light" for="new_product">
                                            <i class="fas fa-star me-2 text-warning"></i>منتج جديد
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_used" id="used_product" 
                                               value="1" checked>
                                        <label class="form-check-label text-light" for="used_product">
                                            <i class="fas fa-recycle me-2 text-success"></i>منتج مستعمل
                                        </label>
                                    </div>
                                @endif
                            </div>
                            @error('is_used')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حالة المنتج المستعمل -->
                        @if(Auth::user()->user_type === 'user')
                        <div class="mb-3" id="condition_field">
                            <label for="condition" class="form-label text-light">حالة المنتج <span class="text-danger">*</span></label>
                            <select class="form-control dark-input" id="condition" name="condition" required>
                                <option value="">اختر الحالة</option>
                                <option value="جديدة" {{ old('condition') == 'جديدة' ? 'selected' : '' }}>جديدة</option>
                                <option value="جيدة جداً" {{ old('condition') == 'جيدة جداً' ? 'selected' : '' }}>جيدة جداً</option>
                                <option value="جيدة" {{ old('condition') == 'جيدة' ? 'selected' : '' }}>جيدة</option>
                                <option value="متوسطة" {{ old('condition') == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                            </select>
                            @error('condition')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <!-- الصور -->
                        <div class="mb-4">
                            <label for="images" class="form-label text-light">صور المنتج</label>
                            <input type="file" class="form-control dark-input" id="images" name="images[]" 
                                   multiple accept="image/*">
                            <div class="form-text text-muted">
                                يمكنك رفع حتى 5 صور (الحجم الأقصى 2MB لكل صورة)
                            </div>
                            @error('images.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            
                            <!-- معاينة الصور -->
                            <div class="row mt-3" id="imagePreview"></div>
                        </div>

                        <!-- معلومات إضافية -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>معلومات مهمة:</h6>
                            <ul class="mb-0">
                                @if(Auth::user()->user_type === 'merchant')
                                    <li>التجار يمكنهم إضافة منتجات جديدة فقط</li>
                                @else
                                    <li>المستخدمون يمكنهم إضافة منتجات مستعملة فقط</li>
                                @endif
                                <li>الحد الأقصى للمنتجات: {{ Auth::user()->product_limit }} منتج</li>
                                <li>المنتجات تخضع للمراجعة قبل النشر</li>
                                <li>استخدم صوراً واضحة وجودة عالية للمنتج</li>
                            </ul>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ Auth::user()->user_type === 'user' ? route('user.products') : route('merchant.products') }}" 
                               class="btn btn-outline-aqua">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-save me-2"></i>إضافة المنتج
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
    // معاينة الصور
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(e) {
        imagePreview.innerHTML = '';
        const files = e.target.files;
        
        for (let i = 0; i < Math.min(files.length, 5); i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" 
                                 class="img-fluid rounded" 
                                 style="height: 100px; object-fit: cover; width: 100%;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 start-0" 
                                    onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    imagePreview.appendChild(col);
                }
                reader.readAsDataURL(file);
            }
        }
    });

    @if(Auth::user()->user_type === 'user')
    // التحكم في حقل الحالة للمستخدمين
    const newProductRadio = document.getElementById('new_product');
    const usedProductRadio = document.getElementById('used_product');
    const conditionField = document.getElementById('condition_field');

    function toggleConditionField() {
        if (usedProductRadio.checked) {
            conditionField.style.display = 'block';
            document.getElementById('condition').setAttribute('required', 'required');
        } else {
            conditionField.style.display = 'none';
            document.getElementById('condition').removeAttribute('required');
        }
    }

    if (newProductRadio) newProductRadio.addEventListener('change', toggleConditionField);
    if (usedProductRadio) usedProductRadio.addEventListener('change', toggleConditionField);
    
    // التهيئة الأولية
    toggleConditionField();
    @endif
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

.form-check-input:checked {
    background-color: var(--gold-primary);
    border-color: var(--gold-primary);
}

.alert-info {
    background: rgba(32, 201, 151, 0.1);
    border: 1px solid var(--aqua-primary);
    color: var(--text-primary);
}

#imagePreview img {
    border: 2px solid var(--dark-border);
    transition: all 0.3s ease;
}

#imagePreview img:hover {
    border-color: var(--gold-primary);
    transform: scale(1.05);
}
</style>
@endsection
