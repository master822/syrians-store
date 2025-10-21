<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد - سوق السوريين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #f8f9fa;
            --accent-color: #ff6b6b;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --text-dark: #333;
            --text-light: #6c757d;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin: 30px auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 900px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            padding: 40px 0;
            text-align: center;
            border-radius: 20px 20px 0 0;
            margin: -40px -40px 40px -40px;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff20"><polygon points="0,0 1000,50 1000,100 0,100"/></svg>');
            background-size: cover;
        }
        
        .page-header h1 {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .form-section {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
            border: 1px solid rgba(255,255,255,0.5);
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }
        
        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin: 5px;
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
        }
        
        .image-preview:hover {
            transform: scale(1.05);
            border-color: var(--primary-color);
        }
        
        .feature-input {
            margin-bottom: 10px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 10px;
            background: var(--secondary-color);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
        }
        
        .btn-custom:hover {
            background: linear-gradient(135deg, #1e4a8a, var(--primary-color));
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 8px 20px rgba(44, 90, 160, 0.4);
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(44, 90, 160, 0.25);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: none;
            border-radius: 15px;
            color: #155724;
            border-left: 4px solid var(--success-color);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border: none;
            border-radius: 15px;
            color: #721c24;
            border-left: 4px solid var(--accent-color);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="container">
        <div class="form-container" data-aos="fade-up">
            <div class="page-header" data-aos="fade-down">
                <h1><i class="fas fa-plus-circle"></i> إضافة منتج جديد</h1>
                <p class="mb-0">املأ البيانات التالية لإضافة منتج جديد إلى متجرك</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" data-aos="fade-down">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" data-aos="fade-down">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="/merchant/products/store" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- المعلومات الأساسية -->
                <div class="form-section" data-aos="fade-right">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        المعلومات الأساسية
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المنتج *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required placeholder="أدخل اسم المنتج">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">القسم *</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">اختر القسم</option>
                                    <option value="clothes" {{ old('category') == 'clothes' ? 'selected' : '' }}>👕 ملابس</option>
                                    <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>📱 إلكترونيات</option>
                                    <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>🏠 أدوات منزلية</option>
                                    <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>🛒 بقالة</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- السعر والكمية -->
                <div class="form-section" data-aos="fade-left">
                    <h4 class="section-title">
                        <i class="fas fa-tag"></i>
                        السعر والكمية
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر (TL) *</label>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price') }}" min="1" required placeholder="أدخل السعر">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="stock" class="form-label">الكمية المتاحة *</label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       value="{{ old('stock', 1) }}" min="1" required placeholder="الكمية">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
                                <input type="number" class="form-control" id="discount_percentage" 
                                       name="discount_percentage" value="{{ old('discount_percentage', 0) }}" 
                                       min="0" max="100" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الوصف -->
                <div class="form-section" data-aos="fade-right">
                    <h4 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        وصف المنتج
                    </h4>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف المنتج *</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="4" required placeholder="أدخل وصفاً مفصلاً للمنتج">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- المواصفات -->
                <div class="form-section" data-aos="fade-left">
                    <h4 class="section-title">
                        <i class="fas fa-list-alt"></i>
                        المواصفات
                    </h4>
                    
                    <div class="mb-3">
                        <label class="form-label">مواصفات المنتج (اختياري)</label>
                        <div id="features-container">
                            <div class="feature-input input-group">
                                <input type="text" class="form-control" name="features[0][key]" placeholder="المفتاح (مثال: اللون)">
                                <input type="text" class="form-control" name="features[0][value]" placeholder="القيمة (مثال: أحمر)">
                                <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-custom btn-sm mt-2" onclick="addFeature()">
                            <i class="fas fa-plus"></i> إضافة مواصفة
                        </button>
                    </div>
                </div>

                <!-- رفع الصور -->
                <div class="form-section" data-aos="fade-right">
                    <h4 class="section-title">
                        <i class="fas fa-images"></i>
                        صور المنتج
                    </h4>
                    
                    <div class="mb-3">
                        <label for="images" class="form-label">صور المنتج (حد أقصى 6 صور)</label>
                        <input type="file" class="form-control" id="images" name="images[]" 
                               multiple accept="image/*" onchange="previewImages(this)">
                        <small class="text-muted">يمكنك رفع حتى 6 صور للمنتج</small>
                        
                        <div id="image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- زر الإرسال -->
                <div class="text-center mt-4" data-aos="fade-up">
                    <button type="submit" class="btn btn-custom btn-lg">
                        <i class="fas fa-save"></i> إضافة المنتج
                    </button>
                    <a href="/merchant/products" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="fas fa-arrow-right"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let featureCount = 1;

        function addFeature() {
            const container = document.getElementById('features-container');
            const newFeature = document.createElement('div');
            newFeature.className = 'feature-input input-group';
            newFeature.innerHTML = `
                <input type="text" class="form-control" name="features[${featureCount}][key]" placeholder="المفتاح">
                <input type="text" class="form-control" name="features[${featureCount}][value]" placeholder="القيمة">
                <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(newFeature);
            featureCount++;
        }

        function removeFeature(button) {
            button.parentElement.remove();
        }

        function previewImages(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            
            if (input.files) {
                const files = Array.from(input.files).slice(0, 6); // حد أقصى 6 صور
                
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        img.alt = `صورة ${index + 1}`;
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
