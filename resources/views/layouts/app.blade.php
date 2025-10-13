<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'متجر التخفيضات')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* الألوان الأساسية - داكنة دائماً */
            --dark-bg: #0a0b0e;
            --dark-card: #15171e;
            --dark-surface: #1e2129;
            --dark-border: #2a2e3a;
            
            /* ألوان التمييز - ذهبية وزرقاء */
            --gold-primary: #d4af37;
            --gold-secondary: #f7ef8a;
            --gold-glow: #ffd700;
            --aqua-primary: #00e5ff;
            --aqua-secondary: #80f2ff;
            --blue-primary: #3a86ff;
            --blue-secondary: #6ba4ff;
            --red-accent: #ff2e63;
            --red-glow: #ff6b9d;
            
            /* ألوان النص */
            --text-primary: #ffffff;
            --text-secondary: #b0b3c1;
            --text-muted: #6c7280;
        }

        [data-theme="light"] {
            /* الوضع العادي - داكن لكن أقل قتامة */
            --dark-bg: #1a1d28;
            --dark-card: #252837;
            --dark-surface: #2d3142;
            --dark-border: #3a3f5a;
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --text-muted: #718096;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1d28 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            transition: all 0.4s ease;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 229, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(58, 134, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: backgroundFloat 20s ease-in-out infinite;
        }

        [data-theme="light"] body::before {
            background: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 229, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(58, 134, 255, 0.02) 0%, transparent 50%);
        }

        @keyframes backgroundFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        /* Navbar */
        .navbar {
            background: rgba(21, 23, 30, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--dark-border);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="light"] .navbar {
            background: rgba(37, 40, 55, 0.95) !important;
            border-bottom: 1px solid var(--dark-border);
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--gold-primary), var(--aqua-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 600;
            padding: 0.8rem 1.2rem !important;
            margin: 0 4px;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: var(--text-primary) !important;
            background: rgba(212, 175, 55, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        }

        /* Dropdown */
        .dropdown-menu {
            background: rgba(30, 33, 41, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            animation: dropdownAppear 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="light"] .dropdown-menu {
            background: rgba(45, 49, 66, 0.95);
            border: 1px solid var(--dark-border);
        }

        @keyframes dropdownAppear {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-item {
            color: var(--text-secondary);
            padding: 12px 20px;
            margin: 4px 8px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(58, 134, 255, 0.1);
            color: var(--aqua-primary);
            transform: translateX(-8px);
        }

        /* أزرار */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-primary), #e6c34a);
            border: none;
            color: #000 !important;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
            text-decoration: none !important;
            display: inline-block;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-gold:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.6);
            color: #000 !important;
        }

        /* بطاقات */
        .elite-card {
            background: linear-gradient(145deg, var(--dark-card), var(--dark-surface));
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .elite-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-primary), var(--aqua-primary), var(--blue-primary));
            transform: scaleX(0);
            transition: transform 0.6s ease;
        }

        .elite-card:hover::before {
            transform: scaleX(1);
        }

        .elite-card:hover {
            transform: translateY(-12px) rotateX(5deg);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 80px rgba(212, 175, 55, 0.2);
            border-color: rgba(212, 175, 55, 0.3);
        }

        /* تصميم البحث */
        .search-icon {
            background: rgba(30, 33, 41, 0.8);
            border: 1px solid var(--dark-border);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            color: var(--gold-primary);
        }

        [data-theme="light"] .search-icon {
            background: rgba(45, 49, 66, 0.8);
        }

        .search-icon:hover {
            transform: scale(1.1);
            border-color: var(--gold-primary);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
            color: var(--aqua-primary);
        }

        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 11, 14, 0.95);
            backdrop-filter: blur(20px);
            z-index: 9999;
            display: none;
            animation: modalAppear 0.4s ease;
            overflow-y: auto;
        }

        [data-theme="light"] .search-modal {
            background: rgba(26, 29, 40, 0.95);
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
            to {
                opacity: 1;
                backdrop-filter: blur(20px);
            }
        }

        .search-modal-content {
            position: relative;
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .search-modal .search-box {
            background: rgba(30, 33, 41, 0.9);
            border: 2px solid var(--gold-primary);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 60px rgba(212, 175, 55, 0.3);
        }

        [data-theme="light"] .search-modal .search-box {
            background: rgba(45, 49, 66, 0.9);
        }

        .close-search {
            position: absolute;
            top: 20px;
            left: 20px;
            background: none;
            border: none;
            color: var(--gold-primary);
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10000;
        }

        .close-search:hover {
            color: var(--red-accent);
            transform: rotate(90deg);
        }

        /* زر الوضع */
        .theme-toggle {
            background: rgba(30, 33, 41, 0.8);
            border: 1px solid var(--dark-border);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            color: var(--gold-primary);
        }

        [data-theme="light"] .theme-toggle {
            background: rgba(45, 49, 66, 0.8);
        }

        .theme-toggle:hover {
            transform: rotate(180deg) scale(1.1);
            border-color: var(--gold-primary);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
        }

        /* تأثيرات النص */
        .text-gold {
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-aqua {
            background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-blue {
            background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* الفوتر */
        .footer {
            background: linear-gradient(135deg, var(--dark-bg), var(--dark-card));
            border-top: 1px solid var(--dark-border);
            position: relative;
            overflow: hidden;
        }

        [data-theme="light"] .footer {
            background: linear-gradient(135deg, var(--dark-bg), #252837);
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), var(--aqua-primary), transparent);
        }

        /* تخصيص السكرول بار */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gold-primary), var(--aqua-primary));
            border-radius: 6px;
            border: 2px solid var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--aqua-primary), var(--blue-primary));
        }

        /* تأثير التحديد */
        ::selection {
            background: rgba(212, 175, 55, 0.3);
            color: var(--text-primary);
        }

        /* حقول الإدخال */
        .form-control, .form-select {
            background: rgba(30, 33, 41, 0.8) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--text-primary) !important;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        [data-theme="light"] .form-control, 
        [data-theme="light"] .form-select {
            background: rgba(45, 49, 66, 0.8) !important;
            border: 1px solid var(--dark-border) !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--gold-primary) !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2) !important;
            background: rgba(30, 33, 41, 0.9) !important;
            color: var(--text-primary) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        /* تصميم متقدم لنموذج البحث */
        .price-range-container {
            background: rgba(30, 33, 41, 0.6);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .range-inputs {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .range-inputs .form-control {
            flex: 1;
        }

        .range-separator {
            color: var(--gold-primary);
            font-weight: bold;
        }

        .search-filters {
            background: rgba(30, 33, 41, 0.6);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section:last-child {
            margin-bottom: 0;
        }

        .filter-title {
            color: var(--gold-primary);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .filter-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        .filter-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .filter-checkbox:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .filter-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--gold-primary);
        }

        .filter-checkbox label {
            color: var(--text-secondary);
            cursor: pointer;
            margin: 0;
        }

        .search-main-input {
            font-size: 1.2rem;
            padding: 15px 20px;
            border: 2px solid var(--gold-primary) !important;
        }
    </style>
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                متجر التخفيضات
            </a>

            <!-- زر الوضع -->
            <div class="theme-toggle me-3" id="themeToggle">
                <i class="fas fa-moon"></i>
            </div>

            <!-- أيقونة البحث -->
            <div class="search-icon me-3 d-none d-lg-flex" id="searchIcon">
                <i class="fas fa-search"></i>
            </div>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-gold"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- القائمة الرئيسية -->
                <ul class="navbar-nav me-auto">
                    <!-- المنتجات مع القائمة الفرعية -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            المنتجات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">جميع المنتجات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'clothes') }}">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'electronics') }}">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'home') }}">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'grocery') }}">بقالة</a></li>
                        </ul>
                    </li>

                    <!-- التجار مع القائمة الفرعية -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            التجار
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('merchants.index') }}">جميع التجار</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'clothes') }}">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'electronics') }}">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'home') }}">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'grocery') }}">بقالة</a></li>
                        </ul>
                    </li>

                    <!-- العروض -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('discounts') }}">
                            العروض
                        </a>
                    </li>

                    <!-- سوق المستعمل -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.used') }}">
                            سوق المستعمل
                        </a>
                    </li>
                </ul>
                
                <!-- أيقونة البحث للجوال -->
                <div class="search-icon me-3 d-lg-none" id="searchIconMobile">
                    <i class="fas fa-search"></i>
                </div>
                
                <!-- حسابات المستخدمين -->
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->user_type === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users') }}">إدارة المستخدمين</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.products') }}">إدارة المنتجات</a></li>
                                @elseif(Auth::user()->user_type === 'merchant')
                                    <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">لوحة التاجر</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.products') }}">منتجاتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.discounts') }}">تخفيضاتي</a></li>
                                    <li><a class="dropdown-item" href="#">إعدادات المتجر</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">لوحتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products') }}">منتجاتي المستعملة</a></li>
                                    <li><a class="dropdown-item" href="#">المحادثات</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">تعديل الملف الشخصي</a></li>
                                <li><a class="dropdown-item" href="#">تغيير كلمة المرور</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-gold ms-2" href="{{ route('register') }}">
                                إنشاء حساب
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- نافذة البحث المتقدمة -->
    <div class="search-modal" id="searchModal">
        <button class="close-search" id="closeSearch">
            <i class="fas fa-times"></i>
        </button>
        <div class="search-modal-content">
            <div class="search-box">
                <form action="{{ route('products.search') }}" method="GET">
                    <!-- البحث الأساسي -->
                    <div class="mb-4">
                        <label for="searchInput" class="form-label text-gold mb-3 fs-5">
                            <i class="fas fa-search me-2"></i>ابحث عن المنتجات
                        </label>
                        <input type="text" name="query" class="form-control search-main-input" 
                               placeholder="اكتب اسم المنتج الذي تبحث عنه..." 
                               autocomplete="off" id="searchInput">
                    </div>

                    <!-- نطاق السعر -->
                    <div class="price-range-container">
                        <h6 class="filter-title">
                            <i class="fas fa-tag me-2"></i>نطاق السعر
                        </h6>
                        <div class="range-inputs">
                            <input type="number" name="min_price" class="form-control" 
                                   placeholder="الحد الأدنى للسعر" min="0">
                            <span class="range-separator">-</span>
                            <input type="number" name="max_price" class="form-control" 
                                   placeholder="الحد الأقصى للسعر" min="0">
                            <span class="text-muted ms-2">ر.س</span>
                        </div>
                    </div>

                    <!-- الفلاتر المتقدمة -->
                    <div class="search-filters">
                        <!-- التصنيف -->
                        <div class="filter-section">
                            <h6 class="filter-title">
                                <i class="fas fa-layer-group me-2"></i>التصنيف
                            </h6>
                            <select name="category_id" class="form-select">
                                <option value="">جميع التصنيفات</option>
                                @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- نوع المنتج -->
                        <div class="filter-section">
                            <h6 class="filter-title">
                                <i class="fas fa-box me-2"></i>نوع المنتج
                            </h6>
                            <div class="filter-options">
                                <div class="filter-checkbox">
                                    <input type="radio" name="product_type" id="all_products" value="" checked>
                                    <label for="all_products">جميع المنتجات</label>
                                </div>
                                <div class="filter-checkbox">
                                    <input type="radio" name="product_type" id="new_products" value="new">
                                    <label for="new_products">منتجات جديدة</label>
                                </div>
                                <div class="filter-checkbox">
                                    <input type="radio" name="product_type" id="used_products" value="used">
                                    <label for="used_products">منتجات مستعملة</label>
                                </div>
                            </div>
                        </div>

                        <!-- الترتيب -->
                        <div class="filter-section">
                            <h6 class="filter-title">
                                <i class="fas fa-sort me-2"></i>ترتيب حسب
                            </h6>
                            <select name="sort" class="form-select">
                                <option value="newest">الأحدث أولاً</option>
                                <option value="oldest">الأقدم أولاً</option>
                                <option value="price_low">السعر: من الأقل للأعلى</option>
                                <option value="price_high">السعر: من الأعلى للأقل</option>
                                <option value="name">الاسم (أ-ي)</option>
                                <option value="views">الأكثر مشاهدة</option>
                            </select>
                        </div>

                        <!-- خيارات إضافية -->
                        <div class="filter-section">
                            <h6 class="filter-title">
                                <i class="fas fa-filter me-2"></i>خيارات إضافية
                            </h6>
                            <div class="filter-options">
                                <div class="filter-checkbox">
                                    <input type="checkbox" name="has_discount" id="has_discount">
                                    <label for="has_discount">عروض وتخفيضات فقط</label>
                                </div>
                                <div class="filter-checkbox">
                                    <input type="checkbox" name="in_stock" id="in_stock" checked>
                                    <label for="in_stock">منتجات متوفرة</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار البحث -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-2 px-4">
                            <i class="fas fa-undo me-2"></i>إعادة تعيين
                        </button>
                        <button type="submit" class="btn-gold px-4">
                            <i class="fas fa-search me-2"></i>بحث متقدم
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- الفوتر -->
    <footer class="footer mt-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-gold mb-3">متجر التخفيضات</h5>
                    <p class="text-light mb-4">منصة تسوق إلكتروني تقدم أفضل العروض والتخفيضات من تجار موثوقين.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-gold mb-3">روابط سريعة</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">الرئيسية</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-light text-decoration-none">المنتجات</a></li>
                        <li class="mb-2"><a href="{{ route('discounts') }}" class="text-light text-decoration-none">التخفيضات</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-aqua mb-3">التصنيفات</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.byCategory', 'clothes') }}" class="text-light text-decoration-none">ملابس</a></li>
                        <li class="mb-2"><a href="{{ route('products.byCategory', 'electronics') }}" class="text-light text-decoration-none">إلكترونيات</a></li>
                        <li class="mb-2"><a href="{{ route('products.byCategory', 'home') }}" class="text-light text-decoration-none">أدوات منزلية</a></li>
                        <li class="mb-2"><a href="{{ route('products.byCategory', 'grocery') }}" class="text-light text-decoration-none">بقالة</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-blue mb-3">التواصل</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light">0912345678</li>
                        <li class="mb-2 text-light">info@example.com</li>
                        <li class="mb-2 text-light">دمشق، سوريا</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: var(--dark-border);">
            <div class="text-center">
                <p class="mb-0 text-light">&copy; 2024 متجر التخفيضات. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // التحكم في الوضع المظلم/الفاتح
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('i');
        
        // التحقق من التفضيل المحفوظ
        const currentTheme = localStorage.getItem('theme') || 'dark';
        document.body.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        }

        // التحكم في نافذة البحث
        const searchIcon = document.getElementById('searchIcon');
        const searchIconMobile = document.getElementById('searchIconMobile');
        const searchModal = document.getElementById('searchModal');
        const closeSearch = document.getElementById('closeSearch');
        const searchInput = document.getElementById('searchInput');

        function openSearch() {
            searchModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                searchInput.focus();
            }, 100);
        }

        function closeSearchModal() {
            searchModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        searchIcon.addEventListener('click', openSearch);
        searchIconMobile.addEventListener('click', openSearch);
        closeSearch.addEventListener('click', closeSearchModal);

        // إغلاق البحث بالزر Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });

        // إغلاق البحث بالضغط خارج المحتوى
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                closeSearchModal();
            }
        });

        // تأثيرات التمرير للنافبار
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(21, 23, 30, 0.98)';
                navbar.style.backdropFilter = 'blur(25px)';
            } else {
                navbar.style.background = 'rgba(21, 23, 30, 0.95)';
                navbar.style.backdropFilter = 'blur(20px)';
            }
        });

        // إعادة تعيين الفورم
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            document.querySelector('form').reset();
        });
    </script>
    
    @yield('scripts')
</body>
</html>
