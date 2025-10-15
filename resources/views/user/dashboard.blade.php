@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <!-- الإحصائيات -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="text-gold mb-4">
                <i class="fas fa-user me-2"></i>لوحة تحكم المستخدم
            </h1>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المنتجات</h6>
                            <h4 class="text-aqua mb-0">{{ $usedProductsCount }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-boxes fa-2x text-aqua"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات النشطة</h6>
                            <h4 class="text-success mb-0">{{ $activeProductsCount }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المشاهدات</h6>
                            <h4 class="text-warning mb-0">{{ $viewsCount }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-eye fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات المتبقية</h6>
                            <h4 class="text-info mb-0">{{ Auth::user()->product_limit - $usedProductsCount }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-layer-group fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإجراءات السريعة -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-gold text-dark py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>الإجراءات السريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('products.create') }}" class="btn btn-aqua w-100 py-3">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                إضافة منتج مستعمل
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('user.products') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                إدارة المنتجات
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('profile') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-user-edit fa-2x mb-2"></i><br>
                                تعديل الملف الشخصي
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('change-password') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-key fa-2x mb-2"></i><br>
                                تغيير كلمة المرور
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الحساب -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-info-circle me-2"></i>معلومات الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-aqua">الاسم:</strong>
                        <span class="text-light">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">البريد الإلكتروني:</strong>
                        <span class="text-light">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">رقم الهاتف:</strong>
                        <span class="text-light">{{ Auth::user()->phone ?? 'غير مضاف' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">المدينة:</strong>
                        <span class="text-light">{{ Auth::user()->city }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">نوع الحساب:</strong>
                        <span class="badge bg-info">مستخدم عادي</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">الحد المسموح:</strong>
                        <span class="text-light">{{ Auth::user()->product_limit }} منتج</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- أحدث المنتجات -->
        <div class="col-md-6">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-clock me-2"></i>أحدث المنتجات
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentProducts->count() > 0)
                        @foreach($recentProducts as $product)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-secondary">
                                <div class="flex-shrink-0">
                                    @if($product->images)
                                        @php
                                            $images = json_decode($product->images);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-dark rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-dark rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-light mb-1">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-aqua">{{ number_format($product->price) }} ل.س</span>
                                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($usedProductsCount > 3)
                            <div class="text-center mt-3">
                                <a href="{{ route('user.products') }}" class="btn btn-outline-aqua btn-sm">
                                    عرض جميع المنتجات
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد منتجات حتى الآن</p>
                            <a href="{{ route('products.create') }}" class="btn btn-gold">إضافة أول منتج</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- تقدم استخدام الحساب -->
    <div class="row">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-chart-pie me-2"></i>تقدم استخدام الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-light mb-3">المنتجات المستخدمة</h6>
                            <div class="progress mb-4" style="height: 25px;">
                                @php
                                    $usagePercentage = min(100, ($usedProductsCount / Auth::user()->product_limit) * 100);
                                @endphp
                                <div class="progress-bar bg-{{ $usagePercentage >= 90 ? 'danger' : ($usagePercentage >= 70 ? 'warning' : 'success') }}" 
                                     role="progressbar" 
                                     style="width: {{ $usagePercentage }}%"
                                     aria-valuenow="{{ $usagePercentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $usedProductsCount }}/{{ Auth::user()->product_limit }}
                                </div>
                            </div>
                            <p class="text-muted">
                                @if($usagePercentage >= 90)
                                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                    قريباً من الوصول للحد الأقصى
                                @elseif($usagePercentage >= 70)
                                    <i class="fas fa-info-circle text-info me-1"></i>
                                    استخدمت {{ round($usagePercentage) }}% من المساحة المتاحة
                                @else
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    لديك مساحة كافية لإضافة المزيد من المنتجات
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-light mb-3">نشاط الحساب</h6>
                            <div class="activity-stats">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-light">المشاهدات الإجمالية:</span>
                                    <span class="text-aqua">{{ $viewsCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-light">نسبة النجاح:</span>
                                    <span class="text-success">
                                        @php
                                            $successRate = $usedProductsCount > 0 ? ($activeProductsCount / $usedProductsCount) * 100 : 0;
                                        @endphp
                                        {{ round($successRate) }}%
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-light">حالة الحساب:</span>
                                    <span class="badge bg-{{ Auth::user()->is_active ? 'success' : 'secondary' }}">
                                        {{ Auth::user()->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    transition: transform 0.3s ease;
    border: 1px solid var(--dark-border);
}

.stats-card:hover {
    transform: translateY(-5px);
}

.btn-aqua {
    background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary));
    border: none;
    color: #000;
    font-weight: 600;
}

.btn-aqua:hover {
    background: linear-gradient(135deg, var(--aqua-secondary), var(--aqua-primary));
    color: #000;
    transform: translateY(-2px);
}

.progress {
    background: var(--dark-surface);
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    font-weight: 600;
}

.activity-stats {
    background: var(--dark-surface);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid var(--dark-border);
}
</style>
@endsection
