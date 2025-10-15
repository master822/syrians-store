<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'متجر التخفيضات')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-surface: #334155;
            --dark-border: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --gold-primary: #d4af37;
            --gold-secondary: #f7ef8a;
            --aqua-primary: #20c997;
            --aqua-secondary: #96f2d7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--dark-border);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: var(--text-primary) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: var(--gold-primary) !important;
            transform: translateY(-2px);
        }

        .dropdown-menu {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 10px;
            min-width: 200px;
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: var(--dark-surface);
            color: var(--gold-primary);
        }

        .elite-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .elite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            border: none;
            color: #000;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
            color: #000;
        }

        .btn-aqua {
            background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
            border: none;
            color: #000;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-aqua:hover {
            background: linear-gradient(135deg, var(--aqua-secondary), var(--aqua-primary));
            color: #000;
            transform: translateY(-2px);
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .text-aqua {
            color: var(--aqua-primary) !important;
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary)) !important;
        }

        .bg-aqua {
            background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary)) !important;
        }

        .main-content {
            flex: 1;
            padding-top: 100px; /* مساحة لل navbar الثابت */
            min-height: calc(100vh - 200px);
        }

        .footer {
            background: var(--dark-card);
            border-top: 1px solid var(--dark-border);
            margin-top: auto;
            padding: 2rem 0;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold-primary);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--aqua-primary);
            color: #000;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .search-icon {
            color: var(--text-secondary);
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .search-icon:hover {
            color: var(--gold-primary);
            transform: scale(1.1);
        }

        .search-modal .modal-content {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 15px;
        }

        .search-modal .form-control {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .search-modal .form-control:focus {
            border-color: var(--gold-primary);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        /* تحسينات للوضع المتنقل */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
                font-size: 1rem;
            }
            
            .dropdown-menu {
                text-align: right;
            }
            
            .main-content {
                padding-top: 80px;
            }
            
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* تخصيص شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-surface);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--gold-secondary), var(--gold-primary));
        }

        /* تحسينات عامة للقراءة */
        .container, .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* تحسينات للجداول */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
            border-color: var(--dark-border);
        }

        /* تحسينات للنماذج */
        .form-control, .form-select {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            background: var(--dark-surface);
            border-color: var(--gold-primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        /* تحسينات للبطاقات */
        .card-body {
            padding: 1.5rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        /* تحسينات للأزرار */
        .btn {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }

        /* تحسينات للنصوص */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        /* منع التكرار في التمرير */
        .content-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <!-- شريط التنقل -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <!-- الشعار -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-tags me-2"></i>متجر التخفيضات
                </a>

                <!-- زر القائمة للموبايل -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- عناصر القائمة -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>الرئيسية
                            </a>
                        </li>
                        
                        <!-- المنتجات مع قائمة منسدلة -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-box me-1"></i>المنتجات
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('products.index') }}">
                                    <i class="fas fa-boxes me-2"></i>جميع المنتجات
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('products.new') }}">
                                    <i class="fas fa-star me-2"></i>منتجات جديدة
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('products.used') }}">
                                    <i class="fas fa-recycle me-2"></i>منتجات مستعملة
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('discounts') }}">
                                    <i class="fas fa-tag me-2"></i>التخفيضات
                                </a></li>
                            </ul>
                        </li>

                        <!-- التجار مع قائمة منسدلة -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-store me-1"></i>التجار
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('merchants.index') }}">
                                    <i class="fas fa-list me-2"></i>جميع التجار
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'electronics') }}">
                                    <i class="fas fa-laptop me-2"></i>تجار الإلكترونيات
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'clothes') }}">
                                    <i class="fas fa-tshirt me-2"></i>تجار الملابس
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'home') }}">
                                    <i class="fas fa-home me-2"></i>تجار الأدوات المنزلية
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'grocery') }}">
                                    <i class="fas fa-shopping-basket me-2"></i>تجار البقالة
                                </a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('discounts') }}">
                                <i class="fas fa-tag me-1"></i>التخفيضات
                            </a>
                        </li>
                    </ul>

                    <!-- البحث والإشعارات -->
                    <div class="d-flex align-items-center me-3">
                        <!-- أيقونة البحث -->
                        <i class="fas fa-search search-icon me-3" data-bs-toggle="modal" data-bs-target="#searchModal" style="font-size: 1.2rem;"></i>

                        <!-- الإشعارات -->
                        @auth
                        <div class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell" style="font-size: 1.2rem;"></i>
                                <span class="notification-badge">3</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-gift me-2 text-success"></i>عرض جديد
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-star me-2 text-warning"></i>تقييم جديد
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-shopping-cart me-2 text-primary"></i>طلب جديد
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="#">
                                    عرض جميع الإشعارات
                                </a></li>
                            </ul>
                        </div>
                        @endauth
                    </div>

                    <!-- عناصر المستخدم -->
                    <ul class="navbar-nav">
                        @auth
                            <!-- الملف الشخصي -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                                   role="button" data-bs-toggle="dropdown">
                                    <img src="{{ Auth::user()->avatar_url }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="user-avatar me-2">
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-crown me-2"></i>لوحة التحكم
                                        </a></li>
                                    @elseif(Auth::user()->isMerchant())
                                        <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">
                                            <i class="fas fa-store me-2"></i>لوحة التاجر
                                        </a></li>
                                    @else
                                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                            <i class="fas fa-user me-2"></i>لوحة المستخدم
                                        </a></li>
                                    @endif
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>الملف الشخصي
                                    </a></li>
                                    
                                    <li><a class="dropdown-item" href="{{ route('change-password') }}">
                                        <i class="fas fa-key me-2"></i>تغيير كلمة المرور
                                    </a></li>

                                    @if(Auth::user()->isMerchant())
                                        <li><a class="dropdown-item" href="{{ route('merchant.products') }}">
                                            <i class="fas fa-boxes me-2"></i>منتجاتي
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('merchant.discounts') }}">
                                            <i class="fas fa-tags me-2"></i>التخفيضات
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('products.create') }}">
                                            <i class="fas fa-plus-circle me-2"></i>إضافة منتج
                                        </a></li>
                                    @elseif(Auth::user()->isRegularUser())
                                        <li><a class="dropdown-item" href="{{ route('user.products') }}">
                                            <i class="fas fa-boxes me-2"></i>منتجاتي
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('products.create') }}">
                                            <i class="fas fa-plus-circle me-2"></i>إضافة منتج
                                        </a></li>
                                    @endif

                                    <li><a class="dropdown-item" href="{{ route('chat') }}">
                                        <i class="fas fa-comments me-2"></i>المحادثات
                                    </a></li>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <!-- زر تسجيل الدخول للمستخدمين الزائرين -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>تسجيل الدخول
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-gold ms-2" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>إنشاء حساب
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- نافذة البحث -->
        <div class="modal fade search-modal" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-gold">
                            <i class="fas fa-search me-2"></i>بحث متقدم
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.search') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label text-light">كلمة البحث</label>
                                <input type="text" name="query" class="form-control" 
                                       placeholder="ابحث عن منتج أو تاجر...">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-light">أقل سعر</label>
                                    <input type="number" name="min_price" class="form-control" placeholder="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-light">أعلى سعر</label>
                                    <input type="number" name="max_price" class="form-control" placeholder="100000">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-light">نوع المنتج</label>
                                <select name="product_type" class="form-control">
                                    <option value="">جميع المنتجات</option>
                                    <option value="new">منتجات جديدة</option>
                                    <option value="used">منتجات مستعملة</option>
                                </select>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gold">
                                    <i class="fas fa-search me-2"></i>بحث
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <main class="main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

        <!-- التذييل -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h5 class="text-gold mb-3">
                            <i class="fas fa-tags me-2"></i>متجر التخفيضات
                        </h5>
                        <p class="text-light">
                            منصة متكاملة لبيع وشراء المنتجات الجديدة والمستعملة بأفضل الأسعار والتخفيضات.
                        </p>
                        <div class="social-links">
                            <a href="#" class="text-aqua me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-aqua me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-aqua me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mb-4">
                        <h6 class="text-gold mb-3">روابط سريعة</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">الرئيسية</a></li>
                            <li class="mb-2"><a href="{{ route('products.index') }}" class="text-light text-decoration-none">المنتجات</a></li>
                            <li class="mb-2"><a href="{{ route('merchants.index') }}" class="text-light text-decoration-none">التجار</a></li>
                            <li class="mb-2"><a href="{{ route('discounts') }}" class="text-light text-decoration-none">التخفيضات</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 mb-4">
                        <h6 class="text-gold mb-3">الحساب</h6>
                        <ul class="list-unstyled">
                            @auth
                                <li class="mb-2"><a href="{{ route('profile') }}" class="text-light text-decoration-none">الملف الشخصي</a></li>
                                <li class="mb-2"><a href="{{ route('change-password') }}" class="text-light text-decoration-none">كلمة المرور</a></li>
                            @else
                                <li class="mb-2"><a href="{{ route('login') }}" class="text-light text-decoration-none">تسجيل الدخول</a></li>
                                <li class="mb-2"><a href="{{ route('register') }}" class="text-light text-decoration-none">إنشاء حساب</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <h6 class="text-gold mb-3">معلومات التواصل</h6>
                        <ul class="list-unstyled text-light">
                            <li class="mb-2">
                                <i class="fas fa-envelope me-2 text-aqua"></i>
                                info@example.com
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone me-2 text-aqua"></i>
                                +1234567890
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-aqua"></i>
                                دمشق، سوريا
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">&copy; 2024 متجر التخفيضات. جميع الحقوق محفوظة.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('privacy') }}" class="text-muted text-decoration-none me-3">سياسة الخصوصية</a>
                        <a href="{{ route('terms') }}" class="text-muted text-decoration-none">الشروط والأحكام</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
