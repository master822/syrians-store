<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التخفيضات - سوق السوريين</title>
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
        
        .page-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            padding: 50px 0;
            text-align: center;
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
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .content-section {
            padding: 40px;
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
        
        .discounts-table {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        
        .table th {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            border: none;
            padding: 20px 15px;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .table td {
            padding: 18px 15px;
            vertical-align: middle;
            border-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover td {
            background: rgba(44, 90, 160, 0.05);
            transform: scale(1.01);
        }
        
        .discount-badge {
            background: linear-gradient(135deg, var(--accent-color), #ff4757);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(255, 107, 107, 0.3);
        }
        
        .price-original {
            text-decoration: line-through;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .price-discounted {
            color: var(--success-color);
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .savings-badge {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: white;
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .category-badge {
            background: linear-gradient(135deg, var(--info-color), #0dcaf0);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .status-active { 
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--text-light);
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 20px;
            margin: 20px 0;
        }
        
        .empty-state i {
            font-size: 5rem;
            margin-bottom: 25px;
            opacity: 0.3;
            color: var(--primary-color);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.5);
            margin-bottom: 30px;
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            margin-left: 10px;
            border: 2px solid #e9ecef;
        }
        
        .discount-images {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }
        
        .discount-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .discount-image:hover {
            transform: scale(1.2);
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="page-container" data-aos="fade-up">
        <!-- الهيدر -->
        <div class="page-header" data-aos="fade-down">
            <div class="container">
                <h1><i class="fas fa-tags"></i> التخفيضات النشطة</h1>
                <p class="lead mb-0">عرض وإدارة جميع تخفيضات متجرك</p>
            </div>
        </div>

        <!-- المحتوى -->
        <div class="content-section">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" data-aos="fade-down">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-left">
                <h3 class="text-primary">
                    <i class="fas fa-percentage"></i>
                    قائمة التخفيضات
                </h3>
                <a href="/merchant/discounts/create" class="btn btn-custom">
                    <i class="fas fa-plus"></i> إنشاء تخفيض جديد
                </a>
            </div>

            @if($products->count() > 0)
                <!-- إحصائيات -->
                <div class="stats-card" data-aos="fade-up">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="text-primary">{{ $products->count() }}</h4>
                            <p class="mb-0">إجمالي المنتجات المخفضة</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-success">{{ number_format($products->sum('discount_percentage') / $products->count(), 1) }}%</h4>
                            <p class="mb-0">متوسط نسبة التخفيض</p>
                        </div>
                        <div class="col-md-4">
                            @php
                                $totalSavings = 0;
                                foreach($products as $product) {
                                    $totalSavings += $product->price * ($product->discount_percentage / 100);
                                }
                            @endphp
                            <h4 class="text-danger">{{ number_format($totalSavings) }} ل.س</h4>
                            <p class="mb-0">إجمالي التوفير للعملاء</p>
                        </div>
                    </div>
                </div>

                <!-- جدول التخفيضات -->
                <div class="discounts-table" data-aos="fade-up">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>القسم</th>
                                    <th>السعر</th>
                                    <th>التخفيض</th>
                                    <th>السعر بعد الخصم</th>
                                    <th>التوفير</th>
                                    <th>المخزون</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                @php
                                    $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                    $savings = $product->price * ($product->discount_percentage / 100);
                                    $discountImages = $product->getDiscountImages();
                                @endphp
                                <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $product->getFirstImage() }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="product-image">
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                @if(count($discountImages) > 0)
                                                <div class="discount-images">
                                                    @foreach(array_slice($discountImages, 0, 3) as $image)
                                                    <img src="{{ $image }}" alt="صورة تخفيض" class="discount-image">
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $categoryNames = [
                                                'clothes' => '👕 ملابس',
                                                'electronics' => '📱 إلكترونيات',
                                                'home' => '🏠 أدوات منزلية',
                                                'food' => '🛒 بقالة'
                                            ];
                                        @endphp
                                        <span class="category-badge">
                                            {{ $categoryNames[$product->category] ?? $product->category }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price-original">{{ number_format($product->price) }} ل.س</span>
                                    </td>
                                    <td>
                                        <span class="discount-badge">
                                            {{ $product->discount_percentage }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price-discounted">{{ number_format($discountedPrice) }} ل.س</span>
                                    </td>
                                    <td>
                                        <span class="savings-badge">
                                            وفر {{ number_format($savings) }} ل.س
                                        </span>
                                    </td>
                                    <td>
                                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                            <i class="fas fa-box"></i> {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="تعديل التخفيض">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="إزالة التخفيض">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="empty-state" data-aos="zoom-in">
                    <i class="fas fa-tags"></i>
                    <h4>لا توجد تخفيضات نشطة</h4>
                    <p class="text-muted">لم تقم بإنشاء أي تخفيضات بعد. ابدأ بإنشاء أول تخفيض لمتجرك</p>
                    <a href="/merchant/discounts/create" class="btn btn-custom btn-lg">
                        <i class="fas fa-plus"></i> إنشاء أول تخفيض
                    </a>
                    <div class="mt-3">
                        <a href="/merchant/products" class="btn btn-outline-primary">
                            <i class="fas fa-boxes"></i> عرض جميع المنتجات
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

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
