@extends('layouts.app')

@section('title', 'إضافة منتج مستعمل - لوحة التحكم')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark text-center py-4">
                    <h2 class="mb-0">
                        <i class="fas fa-recycle me-2"></i>
                        إضافة منتج مستعمل
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
                        <!-- نوع المنتج مخفي - للمستخدم دائماً مستعمل -->
                        <input type="hidden" name="is_used" value="1">

                        <!-- اسم المنتج -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-white fs-6 fw-bold">
                                اسم المنتج <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control dark-input fs-6" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="أدخل اسم المنتج" required>
                            @error('name')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- وصف المنتج -->
                        <div class="mb-4">
                            <label for="description" class="form-label text-white fs-6 fw-bold">
                                وصف المنتج <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control dark-input fs-6" 
                                      id="description" name="description" 
                                      rows="5" placeholder="أدخل وصفاً مفصلاً للمنتج وحالته" 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- السعر -->
                        <div class="mb-4">
                            <label for="price" class="form-label text-white fs-6 fw-bold">
                                السعر (TL) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control dark-input fs-6" 
                                   id="price" name="price" value="{{ old('price') }}" 
                                   placeholder="0.00" min="0" required>
                            @error('price')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- التصنيف -->
                        <div class="mb-4">
                            <label for="category_id" class="form-label text-white fs-6 fw-bold">
                                التصنيف <span class="text-danger">*</span>
                            </label>
                            <select class="form-select dark-input fs-6" 
                                    id="category_id" name="category_id" required>
                                <option value="">اختر التصنيف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حالة المنتج -->
                        <div class="mb-4">
                            <label for="condition" class="form-label text-white fs-6 fw-bold">
                                حالة المنتج <span class="text-danger">*</span>
                            </label>
                            <select class="form-select dark-input fs-6" 
                                    id="condition" name="condition" required>
                                <option value="">اختر حالة المنتج</option>
                                <option value="ممتازة" {{ old('condition') == 'ممتازة' ? 'selected' : '' }}>ممتازة</option>
                                <option value="جيدة جداً" {{ old('condition') == 'جيدة جداً' ? 'selected' : '' }}>جيدة جداً</option>
                                <option value="جيدة" {{ old('condition') == 'جيدة' ? 'selected' : '' }}>جيدة</option>
                                <option value="متوسطة" {{ old('condition') == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                                <option value="بحاجة لإصلاح" {{ old('condition') == 'بحاجة لإصلاح' ? 'selected' : '' }}>بحاجة لإصلاح</option>
                            </select>
                            @error('condition')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- صور المنتج -->
                        <div class="mb-4">
                            <label for="images" class="form-label text-white fs-6 fw-bold">
                                صور المنتج (يمكن رفع حتى 5 صور)
                            </label>
                            <input type="file" class="form-control dark-input fs-6" 
                                   id="images" name="images[]" 
                                   multiple accept="image/*" onchange="previewImages(event)">
                            <div class="form-text text-light mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                يمكنك رفع حتى 5 صور للمنتج. الصور المسموح بها: JPEG, PNG, JPG, GIF
                            </div>
                            @error('images.*')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معاينة الصور -->
                        <div class="mb-4" id="imagePreviewSection" style="display: none;">
                            <label class="form-label text-white fs-6 fw-bold">معاينة الصور:</label>
                            <div class="row g-3" id="previewContainer"></div>
                            <div class="mt-2">
                                <small class="text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    يمكنك حذف الصور بالنقر على أيقونة الحذف
                                </small>
                            </div>
                        </div>

                        <!-- عداد الصور -->
                        <div class="mb-4">
                            <div class="alert alert-warning">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-camera me-2 fs-5"></i>
                                    <div>
                                        <strong>عدد الصور المحددة:</strong>
                                        <span id="imageCount" class="badge bg-primary ms-2">0</span>
                                        <span class="text-muted">/ 5</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات إضافية -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading text-dark">
                                <i class="fas fa-info-circle me-2"></i>معلومات مهمة:
                            </h6>
                            <ul class="mb-0 text-dark">
                                <li>المنتجات المضافة من قبل المستخدمين تظهر كمنتجات مستعملة</li>
                                <li>اختر حالة المنتج بدقة لتعكس الحالة الحقيقية</li>
                                <li>الصور الواضحة تساعد في بيع المنتج بشكل أسرع</li>
                                <li>المنتج سيكون مرئياً في قسم المنتجات المستعملة</li>
                                <li>السعر يجب أن يكون بالليرة التركية (TL)</li>
                            </ul>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('user.products') }}" class="btn btn-outline-aqua btn-lg">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                            <button type="submit" class="btn btn-gold btn-lg px-5" id="submitBtn">
                                <i class="fas fa-plus-circle me-2"></i>إنشاء المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedImages = [];

function previewImages(event) {
    const previewContainer = document.getElementById('previewContainer');
    const imagePreviewSection = document.getElementById('imagePreviewSection');
    const imageCount = document.getElementById('imageCount');
    const files = event.target.files;
    
    previewContainer.innerHTML = '';
    selectedImages = Array.from(files);
    
    if (files.length > 0) {
        imagePreviewSection.style.display = 'block';
        imageCount.textContent = files.length;
        
        // التحقق من عدد الصور
        if (files.length > 5) {
            alert('يمكنك رفع 5 صور كحد أقصى');
            event.target.value = '';
            imagePreviewSection.style.display = 'none';
            imageCount.textContent = '0';
            return;
        }
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-4 col-6';
                col.innerHTML = `
                    <div class="image-preview-card position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 150px; object-fit: cover; width: 100%;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" 
                                onclick="removeImage(${index})" title="حذف الصورة">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="image-number position-absolute top-0 start-0 m-1">
                            <span class="badge bg-dark">${index + 1}</span>
                        </div>
                    </div>
                `;
                previewContainer.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        });
    } else {
        imagePreviewSection.style.display = 'none';
        imageCount.textContent = '0';
    }
}

function removeImage(index) {
    // إنشاء DataTransfer جديد
    const dt = new DataTransfer();
    const input = document.getElementById('images');
    
    // إضافة جميع الملفات ما عدا الملف المراد حذفه
    selectedImages.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    selectedImages = Array.from(dt.files);
    input.files = dt.files;
    
    // تحديث المعاينة
    const event = new Event('change');
    input.dispatchEvent(event);
}

// التحقق من النموذج قبل الإرسال
document.getElementById('productForm').addEventListener('submit', function(e) {
    const files = document.getElementById('images').files;
    const submitBtn = document.getElementById('submitBtn');
    
    if (files.length > 5) {
        e.preventDefault();
        alert('يمكنك رفع 5 صور كحد أقصى');
        return;
    }
    
    // تعطيل الزر أثناء الإرسال
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإنشاء...';
});

// تحسين تجربة المستخدم
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات على الحقول
    const inputs = document.querySelectorAll('.dark-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--gold-primary)';
            this.style.boxShadow = '0 0 0 0.2rem rgba(212, 175, 55, 0.25)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = 'var(--dark-border)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

<style>
.dark-input {
    background: var(--dark-surface);
    border: 2px solid var(--dark-border);
    color: var(--text-primary);
    font-size: 16px !important;
    padding: 12px 15px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.dark-input:focus {
    background: var(--dark-surface);
    border-color: var(--gold-primary);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.form-label {
    font-weight: 700 !important;
    margin-bottom: 10px;
    display: block;
}

.image-preview-card {
    border: 2px solid var(--dark-border);
    border-radius: 10px;
    padding: 10px;
    background: var(--dark-surface);
    transition: all 0.3s ease;
}

.image-preview-card:hover {
    border-color: var(--gold-primary);
    transform: translateY(-2px);
}

.alert-info {
    background: rgba(32, 201, 151, 0.15);
    border: 1px solid var(--aqua-primary);
    border-radius: 10px;
}

.alert-warning {
    background: rgba(255, 193, 7, 0.15);
    border: 1px solid #ffc107;
    border-radius: 10px;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 10px;
}

.btn-gold {
    background: linear-gradient(135deg, var(--gold-primary), #b8941f);
    border: none;
    color: #000;
    transition: all 0.3s ease;
}

.btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    color: #000;
}

.btn-gold:disabled {
    opacity: 0.7;
    transform: none;
    box-shadow: none;
}

.btn-outline-aqua {
    border: 2px solid var(--aqua-primary);
    color: var(--aqua-primary);
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-aqua:hover {
    background: var(--aqua-primary);
    color: #000;
    transform: translateY(-2px);
}

.text-white {
    color: #ffffff !important;
}

.text-light {
    color: #e0e0e0 !important;
}

.form-text {
    font-size: 14px;
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }
    
    .btn-lg {
        padding: 10px 20px;
        font-size: 14px;
    }
    
    .dark-input {
        font-size: 14px !important;
        padding: 10px 12px;
    }
}
</style>
@endsection
