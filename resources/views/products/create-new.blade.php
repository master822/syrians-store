@extends('layouts.app')

@section('title', 'إضافة منتج جديد - لوحة التحكم')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="modern-card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    <h2 class="mb-0 fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة منتج جديد
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">أضف منتجك الجديد إلى المتجر</p>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
                        <!-- نوع المنتج مخفي - للتاجر دائماً جديد -->
                        <input type="hidden" name="is_used" value="0">

                        <!-- اسم المنتج -->
                        <div class="mb-4 animate-fade-in">
                            <label for="name" class="form-label text-dark fs-6 fw-bold">
                                📝 اسم المنتج <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control modern-input fs-6" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="أدخل اسم المنتج هنا..." required>
                            @error('name')
                                <div class="text-danger small mt-2 animate-shake">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- وصف المنتج -->
                        <div class="mb-4 animate-fade-in" style="animation-delay: 0.1s;">
                            <label for="description" class="form-label text-dark fs-6 fw-bold">
                                📄 وصف المنتج <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control modern-input fs-6" 
                                      id="description" name="description" 
                                      rows="5" placeholder="أدخل وصفاً مفصلاً للمنتج..." 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-2 animate-shake">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- السعر -->
                            <div class="col-md-6 mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                                <label for="price" class="form-label text-dark fs-6 fw-bold">
                                    💰 السعر (TL) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-success">
                                        <i class="fas fa-lira-sign"></i>
                                    </span>
                                    <input type="number" step="0.01" class="form-control modern-input fs-6" 
                                           id="price" name="price" value="{{ old('price') }}" 
                                           placeholder="0.00" min="0" required>
                                </div>
                                @error('price')
                                    <div class="text-danger small mt-2 animate-shake">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- التصنيف -->
                            <div class="col-md-6 mb-4 animate-fade-in" style="animation-delay: 0.3s;">
                                <label for="category_id" class="form-label text-dark fs-6 fw-bold">
                                    📂 التصنيف <span class="text-danger">*</span>
                                </label>
                                <select class="form-select modern-input fs-6" 
                                        id="category_id" name="category_id" required>
                                    <option value="">اختر التصنيف...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-2 animate-shake">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- صور المنتج -->
                        <div class="mb-4 animate-fade-in" style="animation-delay: 0.4s;">
                            <label for="images" class="form-label text-dark fs-6 fw-bold">
                                📷 صور المنتج
                            </label>
                            <div class="file-upload-area border-2 border-dashed rounded-3 p-4 text-center bg-light">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5 class="text-dark mb-2">اسحب وأفلت الصور هنا</h5>
                                <p class="text-muted mb-3">أو انقر لاختيار الملفات</p>
                                <input type="file" class="form-control modern-input d-none" 
                                       id="images" name="images[]" 
                                       multiple accept="image/*" onchange="previewImages(event)">
                                <button type="button" class="btn btn-outline-primary btn-lg" onclick="document.getElementById('images').click()">
                                    <i class="fas fa-folder-open me-2"></i>اختر الصور
                                </button>
                                <div class="form-text text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    يمكنك رفع حتى 5 صور (JPEG, PNG, JPG, GIF) - الحد الأقصى 2MB للصورة
                                </div>
                            </div>
                            @error('images.*')
                                <div class="text-danger small mt-2 animate-shake">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معاينة الصور -->
                        <div class="mb-4 animate-fade-in" id="imagePreviewSection" style="display: none; animation-delay: 0.5s;">
                            <label class="form-label text-dark fs-6 fw-bold">🖼️ معاينة الصور:</label>
                            <div class="row g-3" id="previewContainer"></div>
                            <div class="mt-3">
                                <div class="alert alert-warning d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                                    <div>
                                        يمكنك حذف الصور بالنقر على أيقونة ❌
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- عداد الصور -->
                        <div class="mb-4" id="imageCounter" style="display: none;">
                            <div class="progress-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-dark fw-bold">📊 تقدم رفع الصور:</span>
                                    <span id="imageCount" class="badge bg-primary fs-6">0/5</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div id="imageProgress" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات إضافية -->
                        <div class="alert alert-info animate-fade-in" style="animation-delay: 0.6s;">
                            <h6 class="alert-heading text-dark fw-bold">
                                <i class="fas fa-lightbulb me-2"></i>نصائح مهمة:
                            </h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-dark">استخدم أسماء واضحة للمنتجات</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-dark">أضف وصفاً مفصلاً وشاملاً</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-dark">استخدم صوراً عالية الجودة</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-dark">حدد السعر المناسب بالسنت</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top animate-fade-in" style="animation-delay: 0.7s;">
                            <a href="{{ route('merchant.products') }}" class="btn btn-outline-secondary btn-lg px-4 back-btn">
                                <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5 submit-btn" id="submitBtn">
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
    const imageCounter = document.getElementById('imageCounter');
    const imageCount = document.getElementById('imageCount');
    const imageProgress = document.getElementById('imageProgress');
    const files = event.target.files;
    
    previewContainer.innerHTML = '';
    selectedImages = Array.from(files);
    
    if (files.length > 0) {
        imagePreviewSection.style.display = 'block';
        imageCounter.style.display = 'block';
        imageCount.textContent = `${files.length}/5`;
        imageProgress.style.width = `${(files.length / 5) * 100}%`;
        
        // تحديث لون شريط التقدم
        if (files.length === 5) {
            imageProgress.classList.remove('bg-primary', 'bg-warning');
            imageProgress.classList.add('bg-success');
        } else if (files.length >= 3) {
            imageProgress.classList.remove('bg-primary', 'bg-success');
            imageProgress.classList.add('bg-warning');
        } else {
            imageProgress.classList.remove('bg-warning', 'bg-success');
            imageProgress.classList.add('bg-primary');
        }
        
        // التحقق من عدد الصور
        if (files.length > 5) {
            showNotification('يمكنك رفع 5 صور كحد أقصى', 'error');
            event.target.value = '';
            imagePreviewSection.style.display = 'none';
            imageCounter.style.display = 'none';
            return;
        }
        
        Array.from(files).forEach((file, index) => {
            // التحقق من حجم الصورة
            if (file.size > 2 * 1024 * 1024) {
                showNotification('حجم الصورة يجب أن يكون أقل من 2MB', 'error');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-xl-2 col-lg-3 col-md-4 col-6';
                col.innerHTML = `
                    <div class="image-preview-card position-relative animate-pop">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" 
                             style="height: 120px; object-fit: cover; width: 100%;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" 
                                onclick="removeImage(${index})" title="حذف الصورة">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="image-number position-absolute top-0 start-0 m-1">
                            <span class="badge bg-dark rounded-pill">${index + 1}</span>
                        </div>
                        <div class="image-info position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-1">
                            <small>${(file.size / 1024).toFixed(1)} KB</small>
                        </div>
                    </div>
                `;
                previewContainer.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        });
    } else {
        imagePreviewSection.style.display = 'none';
        imageCounter.style.display = 'none';
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
    
    // إظهار رسالة تأكيد
    showNotification('تم حذف الصورة', 'success');
    
    // تحديث المعاينة
    const event = new Event('change');
    input.dispatchEvent(event);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <strong>${type === 'error' ? '❌ خطأ' : '✅ تم'}</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // إزالة الإشعار تلقائياً بعد 5 ثواني
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// التحقق من النموذج قبل الإرسال
document.getElementById('productForm').addEventListener('submit', function(e) {
    const files = document.getElementById('images').files;
    const submitBtn = document.getElementById('submitBtn');
    
    if (files.length > 5) {
        e.preventDefault();
        showNotification('يمكنك رفع 5 صور كحد أقصى', 'error');
        return;
    }
    
    // تعطيل الزر أثناء الإرسال
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري إنشاء المنتج...';
    submitBtn.classList.add('submitting');
});

// تحسين تجربة المستخدم
document.addEventListener('DOMContentLoaded', function() {
    // سحب وإفلات الملفات
    const uploadArea = document.querySelector('.file-upload-area');
    const fileInput = document.getElementById('images');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        fileInput.files = e.dataTransfer.files;
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    });
    
    // إضافة تأثيرات على الحقول
    const inputs = document.querySelectorAll('.modern-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // تأثيرات للأزرار
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<style>
.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.modern-input {
    background: #ffffff;
    border: 2px solid #e9ecef;
    color: #495057;
    font-size: 16px !important;
    padding: 15px 20px;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.modern-input:focus {
    background: #ffffff;
    border-color: #4CAF50;
    color: #495057;
    box-shadow: 0 4px 20px rgba(76, 175, 80, 0.15);
    transform: translateY(-1px);
}

.form-label {
    font-weight: 700 !important;
    margin-bottom: 12px;
    display: block;
    color: #2c3e50 !important;
}

.file-upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.file-upload-area:hover {
    border-color: #4CAF50 !important;
    background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
}

.file-upload-area.drag-over {
    border-color: #4CAF50 !important;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    transform: scale(1.02);
}

.image-preview-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 10px;
    background: #ffffff;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.image-preview-card:hover {
    border-color: #4CAF50;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
}

.alert-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 2px solid #2196F3;
    border-radius: 15px;
    color: #1565C0;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 2px solid #ffc107;
    border-radius: 15px;
    color: #856404;
}

.btn-lg {
    padding: 15px 35px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-success {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.btn-success:hover {
    background: linear-gradient(135deg, #45a049, #3d8b40);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
}

.btn-success:active {
    transform: translateY(0);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.submit-btn.submitting {
    background: linear-gradient(135deg, #6c757d, #5a6268) !important;
    transform: scale(0.98);
}

/* الحركات */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pop {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

.animate-pop {
    animation: pop 0.5s ease-out forwards;
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

/* شريط التقدم */
.progress {
    border-radius: 10px;
    background: #e9ecef;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.5s ease;
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }
    
    .card-body {
        padding: 25px !important;
    }
    
    .btn-lg {
        padding: 12px 25px;
        font-size: 14px;
    }
    
    .modern-input {
        font-size: 14px !important;
        padding: 12px 15px;
    }
}

/* تأثيرات النص */
.text-dark {
    color: #2c3e50 !important;
}

.text-muted {
    color: #6c757d !important;
}

/* إشعارات */
.alert {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
@endsection
