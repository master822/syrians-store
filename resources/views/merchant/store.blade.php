<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر {{ $merchant->store_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 to-purple-900 min-h-screen text-white">
    <div class="container mx-auto px-4 py-8">
        <!-- رأس المتجر -->
        <div class="glass-effect rounded-2xl p-6 mb-8 border border-white/20">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-2xl text-white"></i>
                </div>
                <div class="flex-1 text-center md:text-right">
                    <h1 class="text-3xl font-bold mb-2">{{ $merchant->store_name }}</h1>
                    <p class="text-blue-200 mb-2">{{ $merchant->store_description }}</p>
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $merchant->store_city }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-phone"></i>
                            {{ $merchant->store_phone }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            {{ number_format($ratings['average'] ?? 0, 1) }} ({{ $ratings['count'] ?? 0 }} تقييم)
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- المنتجات -->
        <div class="glass-effect rounded-2xl p-6 border border-white/20">
            <h2 class="text-2xl font-bold mb-6 text-center">منتجات المتجر</h2>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="glass-effect dark:dark-glass rounded-2xl p-4 border border-white/20 hover:border-white/40 transition-all duration-300 transform hover:-translate-y-2 cursor-pointer">
                            <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl mb-4 flex items-center justify-center relative">
                                <i class="fas fa-box text-4xl text-white opacity-80"></i>
                            </div>
                            <h3 class="text-white font-semibold mb-2">{{ $product->name }}</h3>
                            <p class="text-blue-200 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-green-400">{{ number_format($product->price) }} ₺</span>
                                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-shopping-cart ml-2"></i>
                                    اطلب الآن
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-6xl text-blue-300 mb-4"></i>
                    <p class="text-xl text-blue-200">لا توجد منتجات في هذا المتجر بعد</p>
                </div>
            @endif
        </div>

        <!-- التقييمات -->
        <div class="glass-effect rounded-2xl p-6 border border-white/20 mt-8">
            <h2 class="text-2xl font-bold mb-6 text-center">تقييمات العملاء</h2>
            <div class="text-center">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-6 py-3">
                    <i class="fas fa-star text-yellow-400 text-2xl"></i>
                    <span class="text-2xl font-bold">{{ number_format($ratings['average'] ?? 0, 1) }}</span>
                    <span class="text-blue-200">({{ $ratings['count'] ?? 0 }} تقييم)</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>
