@extends('layouts.app')

@section('title', 'ملف التاجر - Syrians')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <!-- معلومات التاجر -->
        <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30 mb-6">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center ml-4">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-white dark:text-slate-100">متجر أحمد للإلكترونيات</h1>
                    <p class="text-white/80 dark:text-slate-400 mt-1">متخصص في بيع الأجهزة الإلكترونية والهواتف</p>
                    <div class="flex items-center mt-2">
                        <div class="flex text-yellow-400 ml-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-white/60 dark:text-slate-400 text-sm">(4.5) - 128 تقييم</span>
                    </div>
                </div>
                <button class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-comment ml-2"></i>
                    محادثة
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- المعلومات الجانبية -->
            <div class="lg:col-span-1">
                <!-- معلومات الاتصال -->
                <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30 mb-6">
                    <h3 class="text-lg font-bold text-white dark:text-slate-100 mb-4">معلومات المتجر</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-white/80 dark:text-slate-400">
                            <i class="fas fa-map-marker-alt ml-2"></i>
                            <span>إسطنبول، تركيا</span>
                        </div>
                        <div class="flex items-center text-white/80 dark:text-slate-400">
                            <i class="fas fa-phone ml-2"></i>
                            <span>+90 555 123 4567</span>
                        </div>
                        <div class="flex items-center text-white/80 dark:text-slate-400">
                            <i class="fas fa-clock ml-2"></i>
                            <span>مفتوح 24/7</span>
                        </div>
                        <div class="flex items-center text-white/80 dark:text-slate-400">
                            <i class="fas fa-user-plus ml-2"></i>
                            <span>منذ 2 سنة</span>
                        </div>
                    </div>
                </div>

                <!-- إحصائيات سريعة -->
                <div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
                    <h3 class="text-lg font-bold text-white dark:text-slate-100 mb-4">إحصائيات المتجر</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 dark:text-slate-400">المنتجات المباعة</span>
                            <span class="text-white dark:text-slate-100 font-bold">1,248</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 dark:text-slate-400">معدل الاستجابة</span>
                            <span class="text-green-400 font-bold">98%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/80 dark:text-slate-400">وقت الشحن</span>
                            <span class="text-white dark:text-slate-100 font-bold">24 ساعة</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- التقييمات -->
            <div class="lg:col-span-2">
                <x-ratings :merchant="$merchant" :ratings="$ratings" />
            </div>
        </div>
    </div>
</div>
@endsection
