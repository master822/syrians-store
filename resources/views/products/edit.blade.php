@extends('layouts.app')

@section('title', 'تعديل المنتج - ' . $product->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="modern-card shadow-lg border-0">
                <div class="card-header bg-warning text-dark text-center py-4 rounded-top">
                    <h2 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2"></i>
                        تعديل المنتج: {{ $product->name }}
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">قم بتحديث معلومات منتجك</p>
                </div>
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>يوجد أخطاء في البيانات:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- الحقول المخفية المطلوبة -->
                        <input type="hidden" name="is_used" value="{{ $product->is_used ? '1' : '0' }}">
                        
                        <!-- اسم المنتج -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-dark fs-6 fw-bold">
                                📝 اسم المنتج <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control modern-input fs-6" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" 
                                   placeholder="أدخل اسم المنتج هنا..." required>
                        </div>

                        <!-- وصف المنتج -->
                        <div class="mb-4">
                            <label for="description" class="form-label text-dark fs-6 fw-bold">
                                📄 وصف المنتج <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control modern-input fs-6" 
                                      id="description" name="description" 
                                      rows="5" placeholder="أدخل وصفاً مفصلاً للمنتج..." 
                                      required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <!-- السعر -->
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label text-dark fs-6 fw-bold">
                                     السعر (TL) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control modern-input fs-6" 
                                           id="price" name="price" value="{{ old('price', $product->price) }}" 
                                           placeholder="0.00" min="0" required>
                                </div>
                            </div>

                            <!-- التصنيف -->
                            <div class="col-md-6 mb-4">
                                <label for="category_id" class="form-label text-dark fs-6 fw-bold">
                                     التصنيف <span class="text-danger">*</span>
                                </label>
                                <select class="form-select modern-input fs-6" 
                                        id="category_id" name="category_id" required>
                                    <option value="">اختر التصنيف...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- نوع المنتج (للإظهار فقط) -->
                        <div class="mb-4">
                            <label class="form-label text-dark fs-6 fw-bold">نوع المنتج</label>
                            <div class="form-control bg-light">
                                @if($product->is_used)
                                    <span class="badge bg-info fs-6">🔄 منتج مستعمل</span>
                                @else
                                    <span class="badge bg-success fs-6">🆕 منتج جديد</span>
                                @endif
                                <small class="text-muted d-block mt-1">لا يمكن تغيير نوع المنتج بعد الإنشاء</small>
                            </div>
                        </div>
                        
                        @if($product->is_used)
                        <div class="mb-4">
                            <label for="condition" class="form-label text-dark fs-6 fw-bold">
                                📊 حالة المنتج <span class="text-danger">*</span>
                            </label>
                            <select class="form-select modern-input fs-6" id="condition" name="condition" required>
                                <option value="">اختر الحالة...</option>
                                <option value="جديدة" {{ old('condition', $product->condition) == 'جديدة' ? 'selected' : '' }}>🆕 جديدة</option>
                                <option value="جيدة جداً" {{ old('condition', $product->condition) == 'جيدة جداً' ? 'selected' : '' }}>⭐ جيدة جداً</option>
                                <option value="جيدة" {{ old('condition', $product->condition) == 'جيدة' ? 'selected' : '' }}>👍 جيدة</option>
                                <option value="متوسطة" {{ old('condition', $product->condition) == 'متوسطة' ? 'selected' : '' }}>🔄 متوسطة</option>
                                <option value="تحتاج إصلاح" {{ old('condition', $product->condition) == 'تحتاج إصلاح' ? 'selected' : '' }}>🔧 تحتاج إصلاح</option>
                            </select>
                        </div>
                        @else
                            <input type="hidden" name="condition" value="">
                        @endif

                        <!-- صور المنتج الحالية -->
                        <div class="mb-4">
                            <label class="form-label text-dark fs-6 fw-bold">🖼️ صور المنتج الحالية</label>
                            @php
                                $currentImages = [];
                                if ($product->images) {
                                    $decodedImages = json_decode($product->images, true);
                                    if (is_array($decodedImages) && !empty($decodedImages)) {
                                        $currentImages = $decodedImages;
                                    }
                                }
                            @endphp
                            
                            @if(!empty($currentImages))
                                <div class="row g-3 mb-3">
                                    @foreach($currentImages as $index => $image)
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                            <div class="image-preview-card position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="img-fluid rounded shadow-sm" 
                                                     style="height: 120px; object-fit: cover; width: 100%;">
                                                <div class="form-check position-absolute top-0 start-0 m-1">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="delete_images[]" value="{{ $image }}" 
                                                           id="delete_{{ $index }}">
                                                    <label class="form-check-label text-white bg-dark bg-opacity-75 px-1 rounded" 
                                                           for="delete_{{ $index }}">حذف</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="alert alert-warning d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                                    <div>
                                        يمكنك حذف الصور الحالية بتحديد خانة "حذف"
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">لا توجد صور للمنتج</p>
                            @endif
                            
                            <!-- إضافة صور جديدة -->
                            <label class="form-label text-dark fs-6 fw-bold mt-3">➕ إضافة صور جديدة</label>
                            <div class="file-upload-area border-2 border-dashed rounded-3 p-4 text-center bg-light">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5 class="text-dark mb-2">اسحب وأفلت الصور هنا</h5>
                                <p class="text-muted mb-3">أو انقر لاختيار الملفات</p>
                                <input type="file" class="form-control modern-input d-none" 
                                       id="images" name="images[]" 
                                       multiple accept="image/*" onchange="previewNewImages(event)">
                                <button type="button" class="btn btn-outline-primary btn-lg" onclick="document.getElementById('images').click()">
                                    <i class="fas fa-folder-open me-2"></i>اختر الصور
                                </button>
                                <div class="form-text text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    يمكنك رفع صور جديدة إضافية (JPEG, PNG, JPG, GIF) - الحد الأقصى 2MB للصورة
                                </div>
                            </div>
                        </div>

                        <!-- معاينة الصور الجديدة -->
                        <div class="mb-4" id="newImagePreviewSection" style="display: none;">
                            <label class="form-label text-dark fs-6 fw-bold">🖼️ معاينة الصور الجديدة:</label>
                            <div class="row g-3" id="newPreviewContainer"></div>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <a href="{{ Auth::user()->user_type === 'user' ? route('user.products') : route('merchant.products') }}" 
                               class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                            </a>
                            <div class="d-flex gap-3">
                               
                                <button type="submit" class="btn btn-warning btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>تحديث المنتج
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج حذف المنتج -->
<form id="deleteForm" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
let newSelectedImages = [];

function previewNewImages(event) {
    const previewContainer = document.getElementById('newPreviewContainer');
    const previewSection = document.getElementById('newImagePreviewSection');
    const files = event.target.files;
    
    previewContainer.innerHTML = '';
    newSelectedImages = Array.from(files);
    
    if (files.length > 0) {
        previewSection.style.display = 'block';
        
        Array.from(files).forEach((file, index) {
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
                    <div class="image-preview-card position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" 
                             style="height: 120px; object-fit: cover; width: 100%;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" 
                                onclick="removeNewImage(${index})" title="حذف الصورة">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="image-number position-absolute top-0 start-0 m-1">
                            <span class="badge bg-primary rounded-pill">${index + 1}</span>
                        </div>
                    </div>
                `;
                previewContainer.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        });
    } else {
        previewSection.style.display = 'none';
    }
}

function removeNewImage(index) {
    const dt = new DataTransfer();
    const input = document.getElementById('images');
    
    newSelectedImages.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    newSelectedImages = Array.from(dt.files);
    input.files = dt.files;
    
    showNotification('تم حذف الصورة', 'success');
    
    const event = new Event('change');
    input.dispatchEvent(event);
}

function confirmDelete() {
    if (confirm('⚠️ هل أنت متأكد من حذف هذا المنتج؟ هذا الإجراء لا يمكن التراجع عنه.')) {
        document.getElementById('deleteForm').submit();
    }
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
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// تحسين تجربة المستخدم
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<style>
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.modern-input {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.modern-input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    color: white;
}

.file-upload-area {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #f59e0b;
    background: #fff9e6;
}

.file-upload-area.drag-over {
    border-color: #10b981;
    background: #f0fdf4;
}

.image-preview-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.image-preview-card:hover {
    border-color: #f59e0b;
    transform: scale(1.02);
}

.alert {
    border-radius: 12px;
    border: none;
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection
