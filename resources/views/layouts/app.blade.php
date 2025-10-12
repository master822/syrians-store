<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'سوق السوريين') - منصة التجارة الإلكترونية</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #BF092F;
            --primary-dark: #132440;
            --primary-blue: #16476A;
            --primary-teal: #3B9797;
            --text-light: #E2E8F0;
            --text-muted: #94A3B8;
            --bg-dark: #0F172A;
            --bg-card: #1E293B;
            --border-color: #334155;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--bg-dark) 100%);
            color: var(--text-light);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .main-container {
            background: transparent;
            min-height: 100vh;
            width: 100%;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(19, 36, 64, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 3px solid var(--primary-red);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            white-space: nowrap;
        }
        
        .nav-link {
            color: var(--text-light) !important;
            font-weight: 600;
            padding: 0.6rem 1rem !important;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .nav-link:hover {
            background: rgba(191, 9, 47, 0.1);
            transform: translateY(-2px);
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow);
            min-width: 200px;
        }
        
        .dropdown-item {
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            margin: 2px 0;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-blue));
            color: white;
            transform: translateX(-5px);
        }
        
        /* Responsive Design */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(19, 36, 64, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 12px;
                margin-top: 10px;
                padding: 1rem;
                border: 1px solid var(--border-color);
            }
            
            .nav-link {
                padding: 0.5rem 0.8rem !important;
                margin: 2px 0;
                text-align: right;
            }
            
            .dropdown-menu {
                background: transparent;
                border: none;
                box-shadow: none;
                padding-right: 1rem;
            }
            
            .dropdown-item {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .search-form {
                min-width: 100% !important;
                margin: 10px 0;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .container {
                padding: 0 10px;
            }
            
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 360px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem !important;
            }
        }

        /* Container Responsive */
        .container {
            width: 100%;
            padding: 0 15px;
            margin: 0 auto;
        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }

        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
        }

        /* Cards and Content */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }
        
        .section-title {
            position: relative;
            padding-right: 20px;
            margin: 25px 0;
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: linear-gradient(to bottom, var(--primary-red), var(--primary-teal));
            border-radius: 2px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red), #a30828);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(191, 9, 47, 0.4);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

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

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.4rem;
                text-align: center;
                padding-right: 0;
                padding-bottom: 10px;
            }

            .section-title::before {
                right: 50%;
                top: auto;
                bottom: 0;
                transform: translateX(50%);
                width: 50px;
                height: 3px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
            
            .card {
                margin-bottom: 1rem;
            }
            
            .row {
                margin: 0 -5px;
            }
            
            .col-md-6, .col-lg-4, .col-xl-3 {
                padding: 0 5px;
            }
        }

        /* Fix for very small screens */
        @media (max-width: 360px) {
            .container {
                padding: 0 8px;
            }
            
            .card-body {
                padding: 0.75rem;
            }
        }

        /* Ensure images are responsive */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Fix for dropdowns on mobile */
        .navbar-toggler {
            border: 1px solid var(--border-color);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.1rem var(--primary-red);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                🛍️ سوق السوريين
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <form action="{{ route('products.search') }}" method="GET" class="d-flex me-auto my-2 my-lg-0 search-form" style="min-width: 250px;">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="ابحث عن منتج..." value="{{ request('query') }}">
                        <button class="btn btn-warning" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Main Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>الرئيسية
                        </a>
                    </li>
                    
                    <!-- Products Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-box me-1"></i>المنتجات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">جميع المنتجات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.new') }}">🆕 منتجات جديدة</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'clothes') }}"><i class="fas fa-tshirt me-2"></i>ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'electronics') }}"><i class="fas fa-laptop me-2"></i>إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'home') }}"><i class="fas fa-home me-2"></i>أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'grocery') }}"><i class="fas fa-shopping-basket me-2"></i>بقالة</a></li>
                        </ul>
                    </li>

                    <!-- Used Products -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.used') }}">
                            <i class="fas fa-recycle me-1"></i>منتجات مستعملة
                        </a>
                    </li>

                    <!-- Merchants Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-store me-1"></i>التجار
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('merchants.index') }}">جميع التجار</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/merchants/category/clothes') }}"><i class="fas fa-tshirt me-2"></i>تجار الملابس</a></li>
                            <li><a class="dropdown-item" href="{{ url('/merchants/category/electronics') }}"><i class="fas fa-laptop me-2"></i>تجار الإلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ url('/merchants/category/home') }}"><i class="fas fa-home me-2"></i>تجار الأدوات المنزلية</a></li>
                            <li><a class="dropdown-item" href="{{ url('/merchants/category/grocery') }}"><i class="fas fa-shopping-basket me-2"></i>تجار البقالة</a></li>
                        </ul>
                    </li>

                    <!-- Advanced Search -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#advancedSearchModal">
                            <i class="fas fa-search-plus me-1"></i>بحث متقدم
                        </a>
                    </li>
                </ul>

                <!-- Auth Links -->
                <ul class="navbar-nav">
                    @auth
                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                @if(Auth::user()->user_type === 'admin')
                                    <span class="badge bg-danger ms-1">أدمن</span>
                                @elseif(Auth::user()->user_type === 'merchant')
                                    <span class="badge bg-warning ms-1">تاجر</span>
                                @else
                                    <span class="badge bg-success ms-1">مستخدم</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->user_type === 'user')
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products') }}"><i class="fas fa-box me-2"></i>منتجاتي</a></li>
                                @elseif(Auth::user()->user_type === 'merchant')
                                    <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>لوحة التاجر</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.products') }}"><i class="fas fa-box me-2"></i>منتجاتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.discounts') }}"><i class="fas fa-tag me-2"></i>التخفيضات</a></li>
                                @elseif(Auth::user()->user_type === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cogs me-2"></i>لوحة الأدمن</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>إنشاء حساب
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Advanced Search Modal -->
    <div class="modal fade" id="advancedSearchModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🔍 بحث متقدم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="modal-body">
                        <!-- Search Query -->
                        <div class="mb-3">
                            <label for="searchQuery" class="form-label">كلمة البحث</label>
                            <input type="text" class="form-control" id="searchQuery" name="query" placeholder="ابحث في اسم أو وصف المنتج...">
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">نطاق السعر (ل.س)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="min_price" placeholder="أقل سعر" min="0">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="max_price" placeholder="أعلى سعر" min="0">
                                </div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">التصنيف</label>
                            <select class="form-select" id="category" name="category_id">
                                <option value="">جميع التصنيفات</option>
                                @foreach(App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Type -->
                        <div class="mb-3">
                            <label class="form-label">نوع المنتج</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_type" id="allProducts" value="" checked>
                                    <label class="form-check-label" for="allProducts">الكل</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_type" id="newProducts" value="new">
                                    <label class="form-check-label" for="newProducts">🆕 جديدة</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_type" id="usedProducts" value="used">
                                    <label class="form-check-label" for="usedProducts">🔄 مستعملة</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">ترتيب حسب</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest">الأحدث أولاً</option>
                                <option value="oldest">الأقدم أولاً</option>
                                <option value="price_low">السعر: من الأقل للأعلى</option>
                                <option value="price_high">السعر: من الأعلى للأقل</option>
                                <option value="name">الاسم: أ-ي</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container fade-in">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>🛍️ سوق السوريين</h5>
                    <p>منصة التجارة الإلكترونية الأولى للسوريين، تجمع بين البائعين والمشترين في مكان واحد.</p>
                </div>
                <div class="col-md-3">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light">الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-light">جميع المنتجات</a></li>
                        <li><a href="{{ route('merchants.index') }}" class="text-light">التجار</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>التواصل</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> info@syriansmarket.com</li>
                        <li><i class="fas fa-phone me-2"></i> +963 123 456 789</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2024 سوق السوريين. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Price range validation
            $('input[name="min_price"], input[name="max_price"]').on('change', function() {
                const minPrice = parseInt($('input[name="min_price"]').val()) || 0;
                const maxPrice = parseInt($('input[name="max_price"]').val()) || 0;
                
                if (maxPrice > 0 && minPrice > maxPrice) {
                    alert('السعر الأدنى يجب أن يكون أقل من أو يساوي السعر الأعلى');
                    $('input[name="min_price"]').val('');
                }
            });

            // Mobile menu improvements
            $('.navbar-nav .nav-link').on('click', function() {
                if ($(window).width() < 992) {
                    $('.navbar-collapse').collapse('hide');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
