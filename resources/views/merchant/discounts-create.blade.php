<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء تخفيض جديد - سوق السوريين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c5aa0;
            --accent-color: #ff6b6b;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-attachment: fixed;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin: 30px auto;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 800px;
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
        
        .product-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .product-card.selected {
            border-color: var(--accent-color);
            background: linear-gradient(135deg, #fff5f5, #ffeaea);
            transform: translateY(-5px);
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            margin-left: 15px;
            border: 2px solid #e9ecef;
        }
        
        .discount-preview {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .original-price {
            text-decoration: line-through;
            opacity: 0.7;
            font-size: 1.2rem;
        }
        
        .discounted-price {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .discount-badge {
            background: var(--accent-color);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
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
        
        .image-upload-section {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            border-left: 4px solid var(--primary-color);
        }
        
        .image-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin: 5px;
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
        }
        
        .image-preview:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="container">
        <div class="form-container" data-aos="fade-up">
            <div class="page-header" data-aos="fade-down">
                <h1><i class="fas fa-tag"></i> إنشاء تخفيض جديد</h1>
                <p class="mb-0">اختر المنتجات التي تريد تطبيق التخفيض عليها وأضف صوراً للتخفيض</p>
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

            <form action="/merchant/discounts/store" method="POST" enctype="multipart/form-data" id="discountForm">
                @csrf
                
                <!-- اختيار المنتجات -->
                <div class="mb-4" data-aos="fade-right">
                    <h4 class="mb-3"><i class="fas fa-boxes"></i> اختر المنتجات</h4>
                    <div class="row" id="productsContainer">
                        @foreach($products as $product)
                        <div class="col-md-6">
                            <div class="product-card" onclick="toggleProduct(this, {{ $product->id }}, {{ $product->price }})">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]" 
                                           value="{{ $product->id }}" id="product{{ $product->id }}" 
                                           style="display: none;">
                                    <label class="form-check-label w-100" for="product{{ $product->id }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $product->getFirstImage() }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="product-image">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                <p class="text-muted mb-1">{{ number_format($product->price) }} ل.س</p>
                                                <small class="text-muted">المخزون: {{ $product->stock }}</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($products->count() === 0)
                        <div class="text-center py-4" data-aos="zoom-in">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5>لا توجد منتجات</h5>
                            <p class="text-muted">يجب أن تضيف منتجات أولاً قبل إنشاء تخفيضات</p>
                            <a href="/merchant/products/create" class="btn btn-custom">
                                <i class="fas fa-plus"></i> إضافة منتج جديد
                            </a>
                        </div>
                    @endif
                </div>

                <!-- إعدادات التخفيض -->
                <div class="mb-4" data-aos="fade-left">
                    <h4 class="mb-3"><i class="fas fa-cog"></i> إعدادات التخفيض</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
                                <input type="number" class="form-control" id="discount_percentage" 
                                       name="discount_percentage" min="1" max="100" value="10"
                                       oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_duration" class="form-label">مدة التخفيض (أيام)</label>
                                <select class="form-select" id="discount_duration" name="discount_duration">
                                    <option value="7">7 أيام</option>
                                    <option value="15">15 يوم</option>
                                    <option value="30">30 يوم</option>
                                    <option value="60">60 يوم</option>
                                    <option value="0">غير محدد</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- رفع صور للتخفيض -->
                <div class="image-upload-section" data-aos="fade-right">
                    <h4 class="mb-3"><i class="fas fa-images"></i> صور التخفيض (اختياري)</h4>
                    <div class="mb-3">
                        <label for="discount_images" class="form-label">أضف صوراً تعبر عن التخفيض</label>
                        <input type="file" class="form-control" id="discount_images" name="discount_images[]" 
                               multiple accept="image/*" onchange="previewDiscountImages(this)">
                        <small class="text-muted">يمكنك رفع حتى 3 صور للتخفيض</small>
                        
                        <div id="discount-images-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- معاينة التخفيض -->
                <div class="discount-preview" data-aos="zoom-in">
                    <h4><i class="fas fa-eye"></i> معاينة التخفيض</h4>
                    <div class="original-price" id="originalPricePreview">0 ل.س</div>
                    <div class="discounted-price" id="discountedPricePreview">0 ل.س</div>
                    <div class="discount-badge" id="discountBadgePreview">0% خصم</div>
                    <p class="mb-0">سيوفر للمشتري: <span id="savingsPreview">0 ل.س</span></p>
                </div>

                <!-- زر الإرسال -->
                <div class="text-center mt-4" data-aos="fade-up">
                    <button type="submit" class="btn btn-custom btn-lg" id="submitBtn" disabled>
                        <i class="fas fa-check"></i> تطبيق التخفيض
                    </button>
                    <a href="/merchant/dashboard" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="fas fa-arrow-right"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedProducts = [];
        let selectedProductPrice = 0;

        function toggleProduct(card, productId, productPrice) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            const isSelected = card.classList.contains('selected');
            
            if (isSelected) {
                card.classList.remove('selected');
                checkbox.checked = false;
                selectedProducts = selectedProducts.filter(id => id !== productId);
                selectedProductPrice = 0;
            } else {
                // إلغاء تحديد جميع المنتجات الأخرى
                document.querySelectorAll('.product-card').forEach(c => c.classList.remove('selected'));
                document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                
                // تحديد المنتج الحالي
                card.classList.add('selected');
                checkbox.checked = true;
                selectedProducts = [productId];
                selectedProductPrice = productPrice;
            }
            
            updateSubmitButton();
            updatePreview();
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = selectedProducts.length === 0;
        }

        function updatePreview() {
            const discountPercentage = parseInt(document.getElementById('discount_percentage').value) || 0;
            const price = selectedProductPrice || 10000; // سعر افتراضي إذا لم يتم اختيار منتج
            const discountAmount = price * (discountPercentage / 100);
            const discountedPrice = price - discountAmount;
            
            document.getElementById('originalPricePreview').textContent = price.toLocaleString() + ' ل.س';
            document.getElementById('discountedPricePreview').textContent = discountedPrice.toLocaleString() + ' ل.س';
            document.getElementById('discountBadgePreview').textContent = discountPercentage + '% خصم';
            document.getElementById('savingsPreview').textContent = discountAmount.toLocaleString() + ' ل.س';
        }

        function previewDiscountImages(input) {
            const preview = document.getElementById('discount-images-preview');
            preview.innerHTML = '';
            
            if (input.files) {
                const files = Array.from(input.files).slice(0, 3); // حد أقصى 3 صور
                
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        img.alt = `صورة تخفيض ${index + 1}`;
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        // تحديث المعاينة عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
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
