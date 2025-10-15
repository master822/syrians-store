@extends('layouts.app')

@section('title', 'لوحة تحكم المسؤول - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <!-- رأس لوحة التحكم -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="text-gold mb-2">
                        <i class="fas fa-crown me-2"></i>لوحة تحكم المسؤول
                    </h1>
                    <p class="text-light mb-0">مرحباً بك في لوحة التحكم الشاملة للموقع</p>
                </div>
                <div class="text-end">
                    <div class="text-aqua fw-bold fs-5">{{ now()->format('Y-m-d') }}</div>
                    <div class="text-muted">آخر تحديث</div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإحصائيات الرئيسية -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المستخدمين</h6>
                            <h4 class="text-aqua mb-0">{{ $stats['total_users'] }}</h4>
                            <small class="text-muted">+{{ $stats['today_registrations'] }} اليوم</small>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-users fa-2x text-aqua"></i>
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
                            <h6 class="text-muted mb-2">إجمالي التجار</h6>
                            <h4 class="text-warning mb-0">{{ $stats['total_merchants'] }}</h4>
                            <small class="text-muted">نشطين</small>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-store fa-2x text-warning"></i>
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
                            <h6 class="text-muted mb-2">إجمالي المنتجات</h6>
                            <h4 class="text-success mb-0">{{ $stats['total_products'] }}</h4>
                            <small class="text-muted">{{ $stats['active_products'] }} نشطة</small>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-boxes fa-2x text-success"></i>
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
                            <h6 class="text-muted mb-2">الإيرادات الشهرية</h6>
                            <h4 class="text-danger mb-0">{{ number_format($revenueStats['monthly_revenue']) }} ل.س</h4>
                            <small class="text-muted">إجمالي: {{ number_format($revenueStats['total_revenue']) }} ل.س</small>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإحصائيات الثانوية -->
    <div class="row mb-5">
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-tags fa-2x text-info mb-2"></i>
                <h6 class="text-light mb-1">{{ $stats['total_categories'] }}</h6>
                <small class="text-muted">التصنيفات</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                <h6 class="text-light mb-1">{{ $stats['total_ratings'] }}</h6>
                <small class="text-muted">التقييمات</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-clock fa-2x text-secondary mb-2"></i>
                <h6 class="text-light mb-1">{{ $stats['pending_products'] }}</h6>
                <small class="text-muted">بانتظار المراجعة</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-gift fa-2x text-success mb-2"></i>
                <h6 class="text-light mb-1">{{ $subscriptionStats['free_merchants'] }}</h6>
                <small class="text-muted">مجاني</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-star fa-2x text-primary mb-2"></i>
                <h6 class="text-light mb-1">{{ $subscriptionStats['basic_merchants'] }}</h6>
                <small class="text-muted">أساسي</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-crown fa-2x text-gold mb-2"></i>
                <h6 class="text-light mb-1">{{ $subscriptionStats['premium_merchants'] + $subscriptionStats['medium_merchants'] }}</h6>
                <small class="text-muted">مميز</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- أحدث المستخدمين -->
        <div class="col-xl-6 mb-4">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card d-flex justify-content-between align-items-center py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-users me-2"></i>أحدث المستخدمين
                    </h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-aqua">عرض الكل</a>
                </div>
                <div class="card-body">
                    @if($recentUsers->count() > 0)
                        @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-secondary">
                            <div class="flex-shrink-0">
                                <img src="{{ $user->avatar_url }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-light mb-1">{{ $user->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">{{ $user->email }}</span>
                                    <span class="badge bg-{{ $user->user_type == 'merchant' ? 'warning' : ($user->user_type == 'admin' ? 'danger' : 'info') }}">
                                        {{ $user->user_type == 'merchant' ? 'تاجر' : ($user->user_type == 'admin' ? 'مسؤول' : 'مستخدم') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-2x text-muted mb-3"></i>
                            <p class="text-muted">لا يوجد مستخدمين</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- أحدث المنتجات -->
        <div class="col-xl-6 mb-4">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card d-flex justify-content-between align-items-center py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-boxes me-2"></i>أحدث المنتجات
                    </h5>
                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-aqua">عرض الكل</a>
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
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-dark rounded d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-dark rounded d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-light mb-1">{{ Str::limit($product->name, 30) }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-aqua small">{{ number_format($product->price) }} ل.س</span>
                                    <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                            <p class="text-muted">لا يوجد منتجات</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- الإجراءات السريعة -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-bolt me-2"></i>الإجراءات السريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-aqua w-100 py-3">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                إدارة المستخدمين
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.merchants') }}" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-store fa-2x mb-2"></i><br>
                                إدارة التجار
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                إدارة المنتجات
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.settings') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-cogs fa-2x mb-2"></i><br>
                                إعدادات الموقع
                            </a>
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

.text-gold {
    color: var(--gold-primary) !important;
}
</style>
@endsection
