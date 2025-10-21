@extends('layouts.app')

@section('title', 'لوحة التحكم - Syrians')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white dark:text-slate-100 mb-2">لوحة التحكم</h1>
            <p class="text-white/80 dark:text-slate-400">مرحباً بك في منصة Syrians</p>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 dark:text-slate-400 text-sm">منتجاتي</p>
                        <p class="text-white dark:text-slate-100 text-2xl font-bold">12</p>
                    </div>
                </div>
            </div>

            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 dark:text-slate-400 text-sm">المشاهدات</p>
                        <p class="text-white dark:text-slate-100 text-2xl font-bold">256</p>
                    </div>
                </div>
            </div>

            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-comments text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 dark:text-slate-400 text-sm">الرسائل</p>
                        <p class="text-white dark:text-slate-100 text-2xl font-bold">8</p>
                    </div>
                </div>
            </div>

            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 dark:text-slate-400 text-sm">التقييم</p>
                        <p class="text-white dark:text-slate-100 text-2xl font-bold">4.8</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- الإجراءات السريعة -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- إضافة منتج جديد -->
            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <h2 class="text-xl font-bold text-white dark:text-slate-100 mb-4">إضافة منتج جديد</h2>
                <p class="text-white/80 dark:text-slate-400 mb-4">بيع منتجاتك بسرعة وسهولة</p>
                <button class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>إضافة منتج
                </button>
            </div>

            <!-- المنتجات الأخيرة -->
            <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                <h2 class="text-xl font-bold text-white dark:text-slate-100 mb-4">منتجاتي الأخيرة</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-white/10 dark:bg-slate-700/50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-300 rounded-lg mr-3"></div>
                            <div>
                                <p class="text-white dark:text-slate-100 font-medium">هاتف سامسونج</p>
                                <p class="text-white/60 dark:text-slate-400 text-sm">2500 ₺</p>
                            </div>
                        </div>
                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">مفعل</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white/10 dark:bg-slate-700/50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-300 rounded-lg mr-3"></div>
                            <div>
                                <p class="text-white dark:text-slate-100 font-medium">ساعة يدوية</p>
                                <p class="text-white/60 dark:text-slate-400 text-sm">800 ₺</p>
                            </div>
                        </div>
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">معلق</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- التنقل السريع -->
        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('products') }}" class="glass-effect dark:dark-glass rounded-xl p-4 text-center border border-white/20 dark:border-slate-600/30 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-search text-2xl text-white dark:text-slate-300 mb-2"></i>
                <p class="text-white dark:text-slate-100 font-medium">تصفح المنتجات</p>
            </a>

            <a href="{{ route('chat') }}" class="glass-effect dark:dark-glass rounded-xl p-4 text-center border border-white/20 dark:border-slate-600/30 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-comments text-2xl text-white dark:text-slate-300 mb-2"></i>
                <p class="text-white dark:text-slate-100 font-medium">الدردشة</p>
            </a>

            <a href="{{ route('profile') }}" class="glass-effect dark:dark-glass rounded-xl p-4 text-center border border-white/20 dark:border-slate-600/30 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-user text-2xl text-white dark:text-slate-300 mb-2"></i>
                <p class="text-white dark:text-slate-100 font-medium">الملف الشخصي</p>
            </a>

            <a href="{{ route('about') }}" class="glass-effect dark:dark-glass rounded-xl p-4 text-center border border-white/20 dark:border-slate-600/30 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-info-circle text-2xl text-white dark:text-slate-300 mb-2"></i>
                <p class="text-white dark:text-slate-100 font-medium">عن الموقع</p>
            </a>
        </div>
    </div>
</div>
@endsection
