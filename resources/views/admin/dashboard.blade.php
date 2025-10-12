<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الأدمن</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 min-h-screen text-white">
    <div class="container mx-auto px-4 py-8">
        <!-- رأس الأدمن -->
        <div class="glass-effect rounded-2xl p-6 mb-8 border border-white/20">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">لوحة التحكم - الأدمن</h1>
                <div class="flex items-center gap-4">
                    <span class="text-blue-300">مرحباً، {{ $user->name }}</span>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition-colors">
                        تسجيل الخروج
                    </a>
                </div>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="glass-effect rounded-2xl p-6 border border-white/20 text-center">
                <i class="fas fa-users text-4xl text-blue-400 mb-4"></i>
                <h3 class="text-2xl font-bold">{{ $stats['users'] }}</h3>
                <p class="text-blue-200">إجمالي المستخدمين</p>
            </div>
            
            <div class="glass-effect rounded-2xl p-6 border border-white/20 text-center">
                <i class="fas fa-store text-4xl text-green-400 mb-4"></i>
                <h3 class="text-2xl font-bold">{{ $stats['merchants'] }}</h3>
                <p class="text-blue-200">التجار</p>
            </div>
            
            <div class="glass-effect rounded-2xl p-6 border border-white/20 text-center">
                <i class="fas fa-box text-4xl text-purple-400 mb-4"></i>
                <h3 class="text-2xl font-bold">{{ $stats['products'] }}</h3>
                <p class="text-blue-200">المنتجات</p>
            </div>
        </div>

        <!-- القوائم السريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="/admin/users" class="glass-effect rounded-2xl p-6 border border-white/20 hover:border-blue-400 transition-all block">
                <div class="flex items-center gap-4">
                    <i class="fas fa-users text-3xl text-blue-400"></i>
                    <div>
                        <h3 class="text-xl font-bold">إدارة المستخدمين</h3>
                        <p class="text-blue-200">عرض وتعديل جميع المستخدمين</p>
                    </div>
                </div>
            </a>

            <a href="/admin/products" class="glass-effect rounded-2xl p-6 border border-white/20 hover:border-green-400 transition-all block">
                <div class="flex items-center gap-4">
                    <i class="fas fa-box text-3xl text-green-400"></i>
                    <div>
                        <h3 class="text-xl font-bold">إدارة المنتجات</h3>
                        <p class="text-blue-200">عرض جميع المنتجات في النظام</p>
                    </div>
                </div>
            </a>

            <a href="/admin/categories" class="glass-effect rounded-2xl p-6 border border-white/20 hover:border-purple-400 transition-all block">
                <div class="flex items-center gap-4">
                    <i class="fas fa-tags text-3xl text-purple-400"></i>
                    <div>
                        <h3 class="text-xl font-bold">إدارة الفئات</h3>
                        <p class="text-blue-200">إدارة فئات المنتجات</p>
                    </div>
                </div>
            </a>

            <a href="/" class="glass-effect rounded-2xl p-6 border border-white/20 hover:border-yellow-400 transition-all block">
                <div class="flex items-center gap-4">
                    <i class="fas fa-home text-3xl text-yellow-400"></i>
                    <div>
                        <h3 class="text-xl font-bold">الموقع الرئيسي</h3>
                        <p class="text-blue-200">العودة للصفحة الرئيسية</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</body>
</html>
