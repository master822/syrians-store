
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
                                    @php
                                        $categories = \App\Models\Category::all();
                                    @endphp
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
/* الألوان الأساسية */
:root {
  --primary: #8B5CF6;
  --primary-dark: #7C3AED;
  --secondary: #06B6D4;
  --accent: #F59E0B;
  --success: #10B981;
  --danger: #EF4444;
  --dark: #1F2937;
  --darker: #111827;
}

/* تصميم داكن بالكامل بدون أي أبيض */
body {
  background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 100%);
  color: #E5E7EB;
  min-height: 100vh;
}

/* الكارد الأساسي */
.modern-card {
  background: rgba(30, 41, 59, 0.8);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 16px;
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.modern-card:hover {
  border-color: var(--primary);
  box-shadow: 0 10px 30px rgba(139, 92, 246, 0.2);
  transform: translateY(-2px);
}

/* الحقول */
.modern-input {
  background: rgba(55, 65, 81, 0.6);
  border: 1px solid rgba(75, 85, 99, 0.5);
  color: #F3F4F6;
  border-radius: 10px;
  padding: 12px 16px;
  transition: all 0.3s ease;
}

.modern-input:focus {
  background: rgba(55, 65, 81, 0.8);
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
  color: #F3F4F6;
}

.modern-input::placeholder {
  color: #9CA3AF;
}

/* الأزرار */
.btn-success {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  border: none;
  border-radius: 10px;
  color: white;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-success:hover {
  background: linear-gradient(135deg, var(--primary-dark), var(--primary));
  transform: translateY(-1px);
  box-shadow: 0 5px 15px rgba(139, 92, 246, 0.4);
  color: white;
}

.btn-outline-secondary {
  background: transparent;
  border: 1px solid #4B5563;
  color: #D1D5DB;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
  background: #374151;
  border-color: #6B7280;
  color: #F3F4F6;
  transform: translateY(-1px);
}

/* منطقة رفع الملفات */
.file-upload-area {
  background: rgba(55, 65, 81, 0.4);
  border: 2px dashed #4B5563;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.file-upload-area:hover {
  border-color: var(--primary);
  background: rgba(55, 65, 81, 0.6);
}

.file-upload-area.drag-over {
  border-color: var(--success);
  background: rgba(16, 185, 129, 0.1);
}

/* معاينة الصور */
.image-preview-card {
  background: rgba(55, 65, 81, 0.6);
  border: 1px solid #4B5563;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.image-preview-card:hover {
  border-color: var(--primary);
  transform: scale(1.02);
}

/* التنبيهات */
.alert-info {
  background: rgba(6, 182, 212, 0.1);
  border: 1px solid rgba(6, 182, 212, 0.3);
  border-radius: 12px;
  color: #67E8F9;
}

.alert-warning {
  background: rgba(245, 158, 11, 0.1);
  border: 1px solid rgba(245, 158, 11, 0.3);
  border-radius: 12px;
  color: #FCD34D;
}

/* التسميات */
.form-label {
  color: #E5E7EB;
  font-weight: 600;
  margin-bottom: 8px;
}

/* الأنيميشن البسيطة */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out;
}

.animate-slide-in {
  animation: slideIn 0.5s ease-out;
}

/* شريط التقدم */
.progress {
  background: #374151;
  border-radius: 8px;
  overflow: hidden;
}

.progress-bar {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  border-radius: 8px;
  transition: width 0.3s ease;
}

/* النصوص */
.text-dark {
  color: #F9FAFB !important;
}

.text-muted {
  color: #9CA3AF !important;
}

/* الهيدر */
.card-header {
  background: rgba(30, 41, 59, 0.9) !important;
  border-bottom: 1px solid #374151;
  color: #F9FAFB;
}

/* التكيف مع الشاشات الصغيرة */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }
  
  .modern-card {
    margin: 0;
  }
  
  .btn-lg {
    padding: 12px 20px;
    font-size: 14px;
  }
}

/* تأثيرات بسيطة عند التحميل */
.submit-btn.submitting {
  opacity: 0.7;
  pointer-events: none;
}

/* تحسين شريط التمرير */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #374151;
}

::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: var(--primary-dark);
}
</style>
@endsection
