<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - التاجر</title>
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
        
        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .merchant-header {
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            padding: 50px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .merchant-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff20"><polygon points="0,0 1000,50 1000,100 0,100"/></svg>');
            background-size: cover;
        }
        
        .merchant-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 40px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            border: 1px solid rgba(255,255,255,0.5);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        }
        
        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
        }
        
        .stat-number {
            font-size: 2.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 15px 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .stat-label {
            color: var(--text-dark);
            font-size: 1rem;
            font-weight: 600;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 40px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        
        .action-btn {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 2px solid var(--primary-color);
            border-radius: 20px;
            padding: 25px 20px;
            text-align: center;
            text-decoration: none;
            color: var(--primary-color);
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        
        .action-btn:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            border-color: transparent;
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), #1e4a8a);
            color: white;
            box-shadow: 0 5px 15px rgba(44, 90, 160, 0.3);
        }
        
        .action-btn:hover .action-icon {
            background: white;
            color: var(--primary-color);
        }
        
        .products-section {
            padding: 40px;
            background: white;
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .product-table {
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
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(255, 107, 107, 0.3);
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
        .status-inactive { 
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
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
        
        .category-badge {
            background: linear-gradient(135deg, var(--info-color), #0dcaf0);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="dashboard-container" data-aos="fade-up">
        <!-- الهيدر -->
        <div class="merchant-header" data-aos="fade-down">
            <div class="container">
                <h1>مرحباً {{ Auth::user()->name }}! 🛍️</h1>
                <p class="lead mb-0">لوحة تحكم التاجر - متجر "{{ Auth::user()->store_name }}"</p>
                <small>
                    @php
                        $categoryNames = [
                            'clothes' => '👕 ملابس',
                            'electronics' => '📱 إلكترونيات',
                            'home' => '🏠 أدوات منزلية', 
                            'food' => '🛒 بقالة'
                        ];
                    @endphp
                    فئة المتجر: {{ $categoryNames[Auth::user()->store_category] ?? Auth::user()->store_category }}
                </small>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="stats-grid" data-aos="fade-up">
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-number">{{ $products->count() }}</div>
                <div class="stat-label">المنتجات</div>
            </div>
            
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">الطلبات</div>
            </div>
            
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">0 ل.س</div>
                <div class="stat-label">الإيرادات</div>
            </div>
            
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-number">{{ $products->where('discount_percentage', '>', 0)->count() }}</div>
                <div class="stat-label">التخفيضات النشطة</div>
            </div>
        </div>

        <!-- الإجراءات السريعة -->
        <div class="quick-actions" data-aos="fade-up">
            <a href="/merchant/products/create" class="action-btn" data-aos="flip-left">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span>إضافة منتج جديد</span>
            </a>
            
            <a href="/merchant/discounts/create" class="action-btn" data-aos="flip-left" data-aos-delay="100">
                <div class="action-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <span>إنشاء تخفيض</span>
            </a>
            
            <a href="/merchant/products" class="action-btn" data-aos="flip-left" data-aos-delay="200">
                <div class="action-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <span>إدارة المنتجات</span>
            </a>
            
            <a href="/merchant/discounts" class="action-btn" data-aos="flip-left" data-aos-delay="300">
                <div class="action-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <span>عرض التخفيضات</span>
            </a>
        </div>

        <!-- المنتجات الأخيرة -->
        <div class="products-section" data-aos="fade-up">
            <h3 class="section-title">
                <i class="fas fa-clock"></i>
                آخر المنتجات المضافة
            </h3>
            
            @if($products->count() > 0)
                <div class="product-table">
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
                                @foreach($products->take(5) as $product)
                                <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                                    <td>
                                        <strong>{{ $product->name }}</strong>
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
                                        <strong>{{ number_format($product->price) }} ل.س</strong>
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
                                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="status-badge status-active">
                                                <i class="fas fa-check-circle"></i> نشط
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <i class="fas fa-times-circle"></i> غير نشط
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="/merchant/products" class="btn btn-custom">
                        <i class="fas fa-list"></i> عرض جميع المنتجات
                    </a>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // تهيئة AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // إضافة تأثيرات عند التمرير
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير للبطاقات عند الظهور
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
