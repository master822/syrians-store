<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'متجر التخفيضات')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --gold-color: #f59e0b;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #000000 !important;
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-nav .nav-link {
            color: #ffffff !important;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--gold-color) !important;
        }
        
        .dropdown-menu {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .dropdown-item {
            color: #000000 !important;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: var(--primary-color);
            color: white !important;
        }
        
        .search-icon {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-icon:hover {
            color: var(--gold-color) !important;
        }
        
        .search-modal .modal-content {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* بطاقات حديثة */
        .modern-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            border: none !important;
            border-radius: 20px !important;
            color: #000000 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.4s ease !important;
            overflow: hidden;
            position: relative;
        }
        
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        .modern-card:hover {
            transform: translateY(-10px) scale(1.02) !important;
            box-shadow: 0 20px 50px rgba(99, 102, 241, 0.3) !important;
        }
        
        .form-control, .form-select {
            border: 2px solid #d1d5db !important;
            color: #000000 !important;
            background-color: #ffffff !important;
            border-radius: 12px !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }
        
        .chat-badge {
            background: #10b981;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -2px;
            right: -2px;
        }
        
        .cursor-pointer {
            cursor: pointer;
        }
        
        /* شات جانبي */
        .side-chat {
            position: fixed;
            top: 50%;
            right: -400px;
            transform: translateY(-50%);
            width: 350px;
            height: 500px;
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px 0 0 20px;
            box-shadow: -5px 0 30px rgba(0, 0, 0, 0.3);
            transition: right 0.4s ease;
            z-index: 1000;
        }
        
        .side-chat.open {
            right: 0;
        }
        
        .side-chat-header {
            background: rgba(31, 41, 55, 0.9);
            padding: 15px;
            border-radius: 20px 0 0 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .side-chat-body {
            height: 380px;
            overflow-y: auto;
            padding: 15px;
        }
        
        .side-chat-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .chat-toggle-btn {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 20px 0 0 20px;
            padding: 15px 10px;
            cursor: pointer;
            z-index: 999;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
        }

        /* تحسينات النصوص */
        .text-primary {
            color: #1e293b !important;
        }

        .text-dark {
            color: #000000 !important;
        }

        .text-muted {
            color: #64748b !important;
        }
    </style>
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                متجر التخفيضات
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- القائمة الرئيسية -->
                <ul class="navbar-nav me-auto">
                    <!-- المنتجات مع dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            المنتجات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'clothes') }}">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'electronics') }}">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'home') }}">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'grocery') }}">بقالة</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">جميع المنتجات</a></li>
                        </ul>
                    </li>
                    
                    <!-- التجار مع dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            التجار
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'clothes') }}">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'electronics') }}">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'home') }}">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'grocery') }}">بقالة</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.index') }}">جميع التجار</a></li>
                        </ul>
                    </li>
                    
                    <!-- المنتجات المستعملة -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.used') }}">
                            منتجات مستعملة
                        </a>
                    </li>
                    
                    <!-- التخفيضات مع dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            التخفيضات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.search') }}?product_type=new&category=clothes">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.search') }}?product_type=new&category=electronics">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.search') }}?product_type=new&category=home">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.search') }}?product_type=new&category=grocery">بقالة</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('discounts') }}">جميع التخفيضات</a></li>
                        </ul>
                    </li>
                </ul>
                
                <!-- الأيقونات -->
                <ul class="navbar-nav">
                    <!-- البحث -->
                    <li class="nav-item">
                        <a class="nav-link search-icon" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>
                    
                    <!-- الإشعارات -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge" id="notificationCount">3</span>
                        </a>
                    </li>
                    
                    @auth
                    <!-- القائمة المنسدلة للمستخدم -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(Auth::user()->isRegularUser())
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                لوحة التحكم
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('user.products') }}">
                                منتجاتي
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                الرسائل
                            </a></li>
                            @endif

                            @if(Auth::user()->isMerchant())
                            <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">
                                لوحة المتجر
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('merchant.products') }}">
                                منتجاتي
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('merchant.discounts') }}">
                                التخفيضات
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('merchant.subscription.plans') }}">
                                خطط الاشتراك
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                الرسائل
                            </a></li>
                            @endif

                            @if(Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                لوحة الإدارة
                            </a></li>
                            @endif

                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                الملف الشخصي
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        تسجيل الخروج
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <!-- روابط الزوار -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning" href="{{ route('register') }}">إنشاء حساب</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- محتوى الصفحة -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- زر فتح الشات الجانبي -->
    <button class="chat-toggle-btn" onclick="toggleChat()">
        <i class="fas fa-comments"></i>
    </button>

    <!-- الشات الجانبي -->
    <div class="side-chat" id="sideChat">
        <div class="side-chat-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-light mb-0">المحادثة العامة</h6>
                <button class="btn btn-sm btn-outline-light" onclick="toggleChat()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="side-chat-body">
            <div class="message mb-3">
                <div class="d-flex align-items-start">
                    <img src="https://ui-avatars.com/api/?name=أحمد&background=6366f1&color=fff" 
                         class="rounded-circle me-2" width="30" height="30">
                    <div>
                        <small class="text-light">أحمد - منذ دقيقتين</small>
                        <p class="mb-0 text-light">مرحباً بالجميع! هل هناك عروض جديدة اليوم؟</p>
                    </div>
                </div>
            </div>
            <div class="message mb-3">
                <div class="d-flex align-items-start">
                    <img src="https://ui-avatars.com/api/?name=محمد&background=8b5cf6&color=fff" 
                         class="rounded-circle me-2" width="30" height="30">
                    <div>
                        <small class="text-light">محمد - منذ دقيقة</small>
                        <p class="mb-0 text-light">نعم، هناك تخفيضات رائعة على الإلكترونيات!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-chat-footer">
            @auth
            <form class="chat-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="اكتب رسالتك...">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            @else
            <div class="alert alert-info text-center py-2">
                <a href="{{ route('login') }}" class="text-primary">سجل الدخول</a> للمشاركة
            </div>
            @endauth
        </div>
    </div>

    <!-- نافذة البحث -->
    <div class="modal fade search-modal" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">بحث متقدم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.search') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label text-dark">كلمة البحث</label>
                            <input type="text" name="query" class="form-control" placeholder="ابحث عن منتج...">
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label text-dark">الحد الأدنى للسعر</label>
                                <input type="number" name="min_price" class="form-control" placeholder="أدنى سعر">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-dark">الحد الأقصى للسعر</label>
                                <input type="number" name="max_price" class="form-control" placeholder="أقصى سعر">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">التصنيف</label>
                            <select name="category_id" class="form-select">
                                <option value="">جميع التصنيفات</option>
                                @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-dark">نوع المنتج</label>
                            <select name="product_type" class="form-select">
                                <option value="">جميع المنتجات</option>
                                <option value="new">منتجات جديدة</option>
                                <option value="used">منتجات مستعملة</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">بحث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة الإشعارات -->
    <div class="modal fade" id="notificationsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">الإشعارات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @auth
                        @if(Auth::user()->isMerchant())
                        <!-- إشعارات التاجر -->
                        <div class="notification-item mb-3 p-3 border rounded cursor-pointer" onclick="window.location.href='{{ route('messages.inbox') }}'">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 text-dark">رسالة جديدة من عميل</h6>
                                    <p class="mb-0 text-muted">لديك رسالة جديدة بخصوص منتجك</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item mb-3 p-3 border rounded cursor-pointer" onclick="window.location.href='{{ route('merchant.subscription.plans') }}'">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-crown text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-1 text-dark">ترقية متجرك</h6>
                                    <p class="mb-0 text-muted">قم بترقية متجرك للحصول على ميزات أكثر</p>
                                </div>
                            </div>
                        </div>
                        @elseif(Auth::user()->isRegularUser())
                        <!-- إشعارات المستخدم العادي -->
                        <div class="notification-item mb-3 p-3 border rounded cursor-pointer" onclick="window.location.href='{{ route('merchants.index') }}'">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-store text-success me-3"></i>
                                <div>
                                    <h6 class="mb-1 text-dark">تاجر جديد</h6>
                                    <p class="mb-0 text-muted">تاجر جديد انضم إلى المنصة</p>
                                </div>
                            </div>
                        </div>
                        <div class="notification-item mb-3 p-3 border rounded cursor-pointer" onclick="window.location.href='{{ route('user.products') }}'">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-box text-info me-3"></i>
                                <div>
                                    <h6 class="mb-1 text-dark">رسالة عن منتجك</h6>
                                    <p class="mb-0 text-muted">هناك تفاعل جديد على منتجك المستعمل</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- إشعارات عامة -->
                        <div class="notification-item p-3 border rounded cursor-pointer" onclick="window.location.href='{{ route('profile') }}'">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bell text-success me-3"></i>
                                <div>
                                    <h6 class="mb-1 text-dark">تحديث الحساب</h6>
                                    <p class="mb-0 text-muted">يمكنك تحديث معلومات حسابك</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">سجل الدخول لمشاهدة الإشعارات</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">تسجيل الدخول</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- السكريبتات -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // التحكم في الشات الجانبي
        function toggleChat() {
            const chat = document.getElementById('sideChat');
            chat.classList.toggle('open');
        }

        // جعل عناصر الإشعارات قابلة للنقر
        document.addEventListener('DOMContentLoaded', function() {
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(item => {
                item.style.cursor = 'pointer';
            });
        });
    </script>
</body>
</html>
