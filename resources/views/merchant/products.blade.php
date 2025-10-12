<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات - سوق السوريين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #f8f9fa;
            --accent-color: #ff6b6b;
            --text-dark: #333;
            --text-light: #6c757d;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .page-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            padding: 40px 0;
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
        
        .content-section {
            padding: 30px;
        }
        
        .btn-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            background: #1e4a8a;
            transform: translateY(-2px);
            color: white;
        }
        
        .products-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .table th {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .discount-badge {
            background: var(--accent-color);
            color: white;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .action-buttons .btn {
            margin: 2px;
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="page-container" data-aos="fade-up">
        <!-- الهيدر -->
        <div class="page-header" data-aos="fade-down">
            <div class="container">
                <h1><i class="fas fa-boxes"></i> إدارة المنتجات</h1>
                <p class="lead mb-0">عرض وإدارة جميع منتجات متجرك</p>
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
                    <i class="fas fa-list"></i>
                    قائمة المنتجات
                </h3>
                <a href="/merchant/products/create" class="btn btn-custom">
                    <i class="fas fa-plus"></i> إضافة منتج جديد
                </a>
            </div>

            @if($products->count() > 0)
                <div class="products-table" data-aos="fade-up">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>القسم</th>
                                    <th>السعر</th>
                                    <th>التخفيض</th>
                                    <th>المخزون</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->discount_percentage > 0)
                                            <br><small class="text-success">🔥 منتج مخفض</small>
                                        @endif
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
                                        <span class="badge bg-light text-dark">
                                            {{ $categoryNames[$product->category] ?? $product->category }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($product->price) }} ل.س</strong>
                                        @if($product->discount_percentage > 0)
                                            <br>
                                            <small class="text-success">
                                                بعد الخصم: {{ number_format($product->price - ($product->price * $product->discount_percentage / 100)) }} ل.س
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->discount_percentage > 0)
                                            <span class="discount-badge">
                                                {{ $product->discount_percentage }}%
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-box"></i> {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="status-badge status-active">
                                                <i class="fas fa-check"></i> نشط
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <i class="fas fa-times"></i> غير نشط
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            @if($product->discount_percentage == 0)
                                                <a href="/merchant/discounts/create" class="btn btn-sm btn-outline-success" title="إضافة تخفيض">
                                                    <i class="fas fa-tag"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-4" data-aos="fade-up">
                    <div class="stats-card p-3 bg-light rounded">
                        <strong>إحصائيات:</strong>
                        <span class="text-primary">إجمالي المنتجات: {{ $products->count() }}</span> |
                        <span class="text-success">المنتجات المخفضة: {{ $products->where('discount_percentage', '>', 0)->count() }}</span> |
                        <span class="text-info">المخزون الكلي: {{ $products->sum('stock') }}</span>
                    </div>
                </div>
            @else
                <div class="empty-state" data-aos="zoom-in">
                    <i class="fas fa-box-open"></i>
                    <h4>لا توجد منتجات</h4>
                    <p class="text-muted">ابدأ بإضافة منتجاتك الأولى إلى المتجر</p>
                    <a href="/merchant/products/create" class="btn btn-custom btn-lg">
                        <i class="fas fa-plus"></i> إضافة أول منتج
                    </a>
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
