<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات المتجر - التاجر</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .logout-btn {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font: inherit;
        }
        .logo-preview {
            transition: all 0.3s ease;
        }
        .logo-preview:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-900 to-emerald-900 min-h-screen text-white">
    <!-- النافبار -->
    <nav class="glass-effect border-b border-white/20 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="/merchant/dashboard" class="flex items-center space-x-2">
                        <i class="fas fa-arrow-right text-xl text-green-400"></i>
                        <span class="text-lg font-bold">العودة للوحة التحكم</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-green-300">مرحباً، {{ Auth::user()->name }}</span>
                    <a href="/" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-home ml-1"></i> الموقع الرئيسي
                    </a>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="logout-btn bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt ml-1"></i> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- رسائل التنبيه -->
    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-500/20 border border-green-400 text-green-200 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle ml-2"></i>
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-center">إعدادات المتجر</h1>

            <form action="{{ route('merchant.settings.update') }}" method="POST" enctype="multipart/form-data" class="glass-effect rounded-2xl p-6 border border-white/20">
                @csrf
                
                <!-- لوجو المتجر -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold mb-4">شعار المتجر</label>
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="logo-preview">
                            @if($user->store_logo)
                                <img src="{{ asset('storage/' . $user->store_logo) }}" alt="Store Logo" class="w-32 h-32 rounded-full object-cover border-4 border-green-400 shadow-lg">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center border-4 border-green-400 shadow-lg">
                                    <i class="fas fa-store text-4xl text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="store_logo" accept="image/*" class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white">
                            <p class="text-green-200 text-sm mt-2">يمكنك رفع صورة لشعار متجرك. الحجم الموصى به: 300x300 بكسل</p>
                        </div>
                    </div>
                </div>

                <!-- معلومات المتجر -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- اسم المتجر الحقيقي -->
                    <div>
                        <label class="block text-sm font-medium mb-2">اسم المتجر الحقيقي *</label>
                        <input type="text" name="store_real_name" value="{{ old('store_real_name', $user->store_real_name) }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>
                    </div>

                    <!-- اسم المتجر المعروض -->
                    <div>
                        <label class="block text-sm font-medium mb-2">اسم المتجر المعروض *</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $user->store_name) }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>
                    </div>

                    <!-- هاتف المتجر -->
                    <div>
                        <label class="block text-sm font-medium mb-2">هاتف المتجر *</label>
                        <input type="text" name="store_phone" value="{{ old('store_phone', $user->store_phone) }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>
                    </div>

                    <!-- مدينة المتجر -->
                    <div>
                        <label class="block text-sm font-medium mb-2">مدينة المتجر *</label>
                        <select name="store_city" class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>
                            <option value="">اختر المدينة</option>
                            <option value="إسطنبول" {{ $user->store_city == 'إسطنبول' ? 'selected' : '' }}>إسطنبول</option>
                            <option value="غازي عنتاب" {{ $user->store_city == 'غازي عنتاب' ? 'selected' : '' }}>غازي عنتاب</option>
                            <option value="أنقرة" {{ $user->store_city == 'أنقرة' ? 'selected' : '' }}>أنقرة</option>
                            <option value="أزمير" {{ $user->store_city == 'أزمير' ? 'selected' : '' }}>أزمير</option>
                            <option value="أضنة" {{ $user->store_city == 'أضنة' ? 'selected' : '' }}>أضنة</option>
                            <option value="أنطاليا" {{ $user->store_city == 'أنطاليا' ? 'selected' : '' }}>أنطاليا</option>
                        </select>
                    </div>
                </div>

                <!-- وصف المتجر -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">وصف المتجر *</label>
                    <textarea name="store_description" rows="4" 
                              class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>{{ old('store_description', $user->store_description) }}</textarea>
                </div>

                <!-- عنوان المتجر -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">عنوان المتجر *</label>
                    <input type="text" name="store_address" value="{{ old('store_address', $user->store_address) }}" 
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white" required>
                </div>

                <!-- فئة المتجر -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">فئة المتجر</label>
                    <select name="store_category" class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 focus:outline-none focus:border-green-400 text-white">
                        <option value="">اختر الفئة</option>
                        <option value="electronics" {{ $user->store_category == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                        <option value="clothes" {{ $user->store_category == 'clothes' ? 'selected' : '' }}>ملابس</option>
                        <option value="home" {{ $user->store_category == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                        <option value="food" {{ $user->store_category == 'food' ? 'selected' : '' }}>بقالة</option>
                        <option value="other" {{ $user->store_category == 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>

                <!-- أزرار -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-save ml-2"></i>حفظ التغييرات
                    </button>
                    <a href="/merchant/dashboard" class="flex-1 bg-white/10 border border-white/20 text-white py-3 rounded-lg font-semibold text-center hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-times ml-2"></i>إلغاء
                    </a>
                </div>
            </form>

            <!-- معاينة المتجر -->
            <div class="glass-effect rounded-2xl p-6 border border-white/20 mt-8">
                <h2 class="text-2xl font-bold mb-4">معاينة المتجر</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-200">شاهد كيف يظهر متجرك للعملاء</p>
                    </div>
                    <a href="/store/{{ $user->id }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt ml-2"></i>معاينة المتجر
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // معاينة الصورة قبل الرفع
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.querySelector('input[name="store_logo"]');
            const logoPreview = document.querySelector('.logo-preview');
            
            logoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.innerHTML = `<img src="${e.target.result}" alt="Store Logo" class="w-32 h-32 rounded-full object-cover border-4 border-green-400 shadow-lg">`;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>
