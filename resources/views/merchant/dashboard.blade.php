@extends('layouts.app')

@section('title', 'لوحة تحكم التاجر - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <!-- الإحصائيات -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-gold mb-3">
                <i class="fas fa-store me-2"></i>لوحة تحكم التاجر
            </h1>
            <p class="text-light mb-0">مرحباً بك في لوحة تحكم متجرك</p>
        </div>
    </div>

    <!-- الإحصائيات الرئيسية -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المنتجات</h6>
                            <h4 class="text-aqua mb-0">{{ $stats['total_products'] }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-boxes fa-2x text-aqua"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات النشطة</h6>
                            <h4 class="text-success mb-0">{{ $stats['active_products'] }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المشاهدات</h6>
                            <h4 class="text-warning mb-0">{{ $stats['total_views'] }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-eye fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card stats-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">متوسط التقييم</h6>
                            <h4 class="text-gold mb-0">{{ number_format($stats['average_rating'], 1) }}/5</h4>
                            <small class="text-muted">({{ $stats['total_ratings'] }} تقييم)</small>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-star fa-2x text-gold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإجراءات السريعة -->
    <div class="row mb-4">
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
                                إضافة منتج جديد
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('merchant.products') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                إدارة المنتجات
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('merchant.discounts.create') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-tag fa-2x mb-2"></i><br>
                                إضافة تخفيض
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('merchant.discounts') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-percentage fa-2x mb-2"></i><br>
                                التخفيضات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- معلومات المتجر -->
        <div class="col-md-6 mb-4">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-store me-2"></i>معلومات المتجر
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-aqua">اسم المتجر:</strong>
                        <span class="text-light">{{ $user->store_name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">التصنيف:</strong>
                        <span class="text-light">
                            @if($user->store_category == 'electronics')
                                إلكترونيات
                            @elseif($user->store_category == 'clothes')
                                ملابس
                            @elseif($user->store_category == 'home')
                                أدوات منزلية
                            @elseif($user->store_category == 'grocery')
                                بقالة
                            @else
                                {{ $user->store_category }}
                            @endif
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">الوصف:</strong>
                        <p class="text-light mb-0">{{ $user->store_description }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">هاتف المتجر:</strong>
                        <span class="text-light">{{ $user->store_phone }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-aqua">المدينة:</strong>
                        <span class="text-light">{{ $user->store_city }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- أحدث المنتجات -->
        <div class="col-md-6 mb-4">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-clock me-2"></i>أحدث المنتجات
                    </h5>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        @foreach($products->take(5) as $product)
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

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
