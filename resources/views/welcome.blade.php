<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سوق السوريين - منصة التجارة الإلكترونية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .discount-badge {
            background: linear-gradient(45deg, #FF6B6B, #FF8E53);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .logout-btn {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font: inherit;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen text-white">
    <!-- النافبار -->
    <nav class="glass-effect border-b border-white/20 sticky top-0 z-50" data-aos="fade-down">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- اللوجو -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 floating">
                        <i class="fas fa-store text-2xl text-blue-400"></i>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">سوق السوريين</span>
                    </a>
                </div>

                <!-- شريط البحث -->
                <div class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="🔍 ابحث عن المنتجات، المتاجر، الفئات..." 
                               class="w-full bg-white/10 border border-white/20 rounded-full px-6 py-3 focus:outline-none focus:border-blue-400 text-white placeholder-gray-300 transition-all duration-300 focus:bg-white/15">
                    </div>
                </div>

                <!-- القوائم -->
                <div class="flex items-center space-x-6">
                    <!-- الأقسام -->
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-1 hover:text-blue-300 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-th-large"></i>
                            <span>الأقسام</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 glass-effect rounded-lg border border-white/20 hidden shadow-2xl">
                            <a href="/products?category=electronics" class="block px-4 py-3 hover:bg-white/10 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-mobile-alt ml-2"></i>إلكترونيات
                            </a>
                            <a href="/products?category=clothes" class="block px-4 py-3 hover:bg-white/10 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-tshirt ml-2"></i>ملابس
                            </a>
                            <a href="/products?category=home" class="block px-4 py-3 hover:bg-white/10 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-home ml-2"></i>أدوات منزلية
                            </a>
                            <a href="/products?category=food" class="block px-4 py-3 hover:bg-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-shopping-basket ml-2"></i>بقالة
                            </a>
                        </div>
                    </div>

                    <!-- التخفيضات -->
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-1 hover:text-red-300 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-tag text-red-400"></i>
                            <span class="text-red-400 font-semibold">التخفيضات</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 glass-effect rounded-lg border border-white/20 hidden shadow-2xl">
                            <a href="/discounts?category=clothes" class="block px-4 py-3 hover:bg-red-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-tshirt ml-2 text-red-400"></i>الملابس
                            </a>
                            <a href="/discounts?category=electronics" class="block px-4 py-3 hover:bg-red-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-mobile-alt ml-2 text-red-400"></i>الإلكترونيات
                            </a>
                            <a href="/discounts?category=home" class="block px-4 py-3 hover:bg-red-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-home ml-2 text-red-400"></i>الأدوات المنزلية
                            </a>
                            <a href="/discounts?category=food" class="block px-4 py-3 hover:bg-red-500/20 transition-all duration-300 hover:pr-6">
                                <i class="fas fa-shopping-basket ml-2 text-red-400"></i>البقالة
                            </a>
                        </div>
                    </div>

                    <!-- سوق المستعمل -->
                    <a href="/used-market" class="hover:text-green-300 transition-all duration-300 hover:scale-105">
                        <i class="fas fa-recycle ml-1 text-green-400"></i>سوق المستعمل
                    </a>

                    <!-- التجار -->
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-1 hover:text-yellow-300 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-store text-yellow-400"></i>
                            <span>التجار</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 glass-effect rounded-lg border border-white/20 hidden shadow-2xl">
                            <a href="/stores?category=clothes" class="block px-4 py-3 hover:bg-yellow-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">ملابس</a>
                            <a href="/stores?category=electronics" class="block px-4 py-3 hover:bg-yellow-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">إلكترونيات</a>
                            <a href="/stores?category=home" class="block px-4 py-3 hover:bg-yellow-500/20 border-b border-white/10 transition-all duration-300 hover:pr-6">أدوات منزلية</a>
                            <a href="/stores?category=food" class="block px-4 py-3 hover:bg-yellow-500/20 transition-all duration-300 hover:pr-6">بقالة</a>
                        </div>
                    </div>

                    <!-- زر لوحة التحكم (يظهر بعد التسجيل) -->
                    @auth
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-th-large"></i>
                            <span>لوحة التحكم</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 glass-effect rounded-lg border border-white/20 hidden shadow-2xl">
                            @if(Auth::user()->user_type === 'admin')
                                <a href="/admin/dashboard" class="block px-4 py-3 hover:bg-blue-500/20 border-b border-white/10 transition-all duration-300">
                                    <i class="fas fa-crown ml-2 text-yellow-400"></i>لوحة الأدمن
                                </a>
                            @elseif(Auth::user()->user_type === 'merchant')
                                <a href="/merchant/dashboard" class="block px-4 py-3 hover:bg-green-500/20 border-b border-white/10 transition-all duration-300">
                                    <i class="fas fa-store ml-2 text-green-400"></i>لوحة التاجر
                                </a>
                            @else
                                <a href="/user/dashboard" class="block px-4 py-3 hover:bg-purple-500/20 border-b border-white/10 transition-all duration-300">
                                    <i class="fas fa-user ml-2 text-purple-400"></i>لوحة المستخدم
                                </a>
                            @endif
                            <form action="/logout" method="POST" class="inline w-full">
                                @csrf
                                <button type="submit" class="logout-btn w-full text-right px-4 py-3 hover:bg-red-500/20 text-red-400 transition-all duration-300 block">
                                    <i class="fas fa-sign-out-alt ml-2"></i>تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- زر تسجيل الدخول (يظهر قبل التسجيل) -->
                    <div class="flex items-center space-x-4">
                        <a href="/login" class="hover:text-blue-300 transition-all duration-300 hover:scale-105">تسجيل الدخول</a>
                        <a href="/register" class="bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">إنشاء حساب</a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- رسائل التنبيه -->
    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-500/20 border border-green-400 text-green-200 px-4 py-3 rounded-lg" data-aos="fade-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle ml-2"></i>
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-3 rounded-lg" data-aos="fade-down">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle ml-2"></i>
                {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <!-- الهيرو سيكشن -->
    <section class="relative overflow-hidden">
        <div class="container mx-auto px-4 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-delay="200">
                    <h1 class="text-6xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">سوق السوريين</span>
                        <br>
                        <span class="text-4xl">منصة التجارة الإلكترونية</span>
                    </h1>
                    <p class="text-xl text-blue-200 mb-8 leading-relaxed">
                        اكتشف آلاف المنتجات من أفضل التجار السوريين. تسوق بثقة وبيع منتجاتك بسهولة في منصة واحدة متكاملة.
                    </p>
                    @guest
                    <div class="flex gap-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="/register?type=user" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center gap-2">
                            <i class="fas fa-shopping-bag"></i> ابدأ التسوق
                        </a>
                        <a href="/register?type=merchant" class="bg-white/10 border border-white/20 hover:bg-white/20 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-store"></i> افتح متجرك
                        </a>
                    </div>
                    @endguest
                </div>
                <div data-aos="fade-left" data-aos-delay="300" class="relative">
                    <div class="floating">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="product-card glass-effect rounded-2xl p-4 border border-white/20">
                                <div class="w-full h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl mb-3 flex items-center justify-center">
                                    <i class="fas fa-mobile-alt text-3xl text-white"></i>
                                </div>
                                <div class="discount-badge absolute -top-2 -right-2 text-xs text-white px-2 py-1 rounded-full">خصم 30%</div>
                            </div>
                            <div class="product-card glass-effect rounded-2xl p-4 border border-white/20 mt-8">
                                <div class="w-full h-32 bg-gradient-to-br from-green-500 to-blue-600 rounded-xl mb-3 flex items-center justify-center">
                                    <i class="fas fa-tshirt text-3xl text-white"></i>
                                </div>
                            </div>
                            <div class="product-card glass-effect rounded-2xl p-4 border border-white/20">
                                <div class="w-full h-32 bg-gradient-to-br from-yellow-500 to-red-600 rounded-xl mb-3 flex items-center justify-center">
                                    <i class="fas fa-home text-3xl text-white"></i>
                                </div>
                            </div>
                            <div class="product-card glass-effect rounded-2xl p-4 border border-white/20 mt-8">
                                <div class="w-full h-32 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl mb-3 flex items-center justify-center">
                                    <i class="fas fa-utensils text-3xl text-white"></i>
                                </div>
                                <div class="discount-badge absolute -top-2 -right-2 text-xs text-white px-2 py-1 rounded-full">خصم 25%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم المنتجات الأكثر مبيعاً -->
    <section class="py-16" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">🔥 المنتجات الأكثر مبيعاً</h2>
                <p class="text-xl text-blue-200">اكتشف أفضل المنتجات التي يفضلها عملاؤنا</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 1; $i <= 8; $i++)
                <div class="product-card glass-effect rounded-2xl p-4 border border-white/20" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                    <div class="relative">
                        <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl mb-4 flex items-center justify-center">
                            <i class="fas fa-box text-4xl text-white opacity-80"></i>
                        </div>
                        @if($i % 3 == 0)
                        <div class="discount-badge absolute top-2 left-2 text-white px-3 py-1 rounded-full text-sm font-bold">
                            خصم {{ $i * 5 }}%
                        </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-fire"></i> 🔥
                        </div>
                    </div>
                    <h3 class="text-white font-semibold mb-2 text-lg">منتج متميز {{ $i }}</h3>
                    <p class="text-blue-200 text-sm mb-3 line-clamp-2">هذا المنتج من أفضل المنتجات مبيعاً في منصتنا ويحصل على تقييمات رائعة من العملاء</p>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xl font-bold text-green-400">{{ $i * 1500 }} ₺</span>
                        @if($i % 3 == 0)
                        <span class="text-red-400 text-sm line-through">{{ $i * 2000 }} ₺</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for($j = 1; $j <= 5; $j++)
                            <i class="fas fa-star{{ $j > 4 ? '-half-alt' : '' }} text-sm"></i>
                            @endfor
                            <span class="text-blue-200 text-sm">({{ $i * 12 }})</span>
                        </div>
                        <button class="bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 text-sm">
                            <i class="fas fa-shopping-cart ml-1"></i>أضف للسلة
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- الفوتر -->
    <footer class="glass-effect border-t border-white/20 mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div data-aos="fade-up">
                    <h3 class="text-lg font-bold mb-4">سوق السوريين</h3>
                    <p class="text-blue-200">منصة التجارة الإلكترونية الرائدة للسوريين حول العالم</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-lg font-bold mb-4">روابط سريعة</h3>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-blue-200 hover:text-white transition-colors">عن المنصة</a></li>
                        <li><a href="/contact" class="text-blue-200 hover:text-white transition-colors">اتصل بنا</a></li>
                        <li><a href="/privacy" class="text-blue-200 hover:text-white transition-colors">الخصوصية</a></li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-bold mb-4">التجار</h3>
                    <ul class="space-y-2">
                        <li><a href="/register?type=merchant" class="text-blue-200 hover:text-white transition-colors">افتح متجر</a></li>
                        <li><a href="/pricing" class="text-blue-200 hover:text-white transition-colors">الأسعار</a></li>
                        <li><a href="/merchant/guide" class="text-blue-200 hover:text-white transition-colors">دليل التاجر</a></li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-bold mb-4">التواصل</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-blue-200 hover:text-white transition-colors transform hover:scale-110"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors transform hover:scale-110"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors transform hover:scale-110"><i class="fab fa-instagram text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-8 text-center text-blue-200" data-aos="fade-up">
                <p>© 2024 سوق السوريين. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- المكتبات -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // تهيئة AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // جافاسكريبت للدروب داون
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function() {
                    this.querySelector('.dropdown-menu').classList.remove('hidden');
                });
                dropdown.addEventListener('mouseleave', function() {
                    this.querySelector('.dropdown-menu').classList.add('hidden');
                });
            });

            // تأثيرات للكروت
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
