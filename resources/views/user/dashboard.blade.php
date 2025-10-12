@extends('layouts.app')

@section('title', 'لوحة التحكم - المستخدم')

@section('content')
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 text-primary gradient-text">👤 لوحة التحكم</h1>
                <div class="d-flex gap-2">
                    <span class="badge bg-success fs-6 p-2">{{ auth()->user()->user_type == 'user' ? 'مستخدم عادي' : auth()->user()->user_type }}</span>
                </div>
            </div>
            <p class="text-muted">مرحباً بك، {{ auth()->user()->name }}! هذه لوحة تحكم المستخدم العادي.</p>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card stat-card animated-card">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x text-primary mb-2"></i>
                    <h3>{{ $usedProductsCount }}</h3>
                    <p class="text-muted mb-0">المنتجات المستعملة</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card animated-card">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-2x text-info mb-2"></i>
                    <h3>{{ $activeProductsCount }}</h3>
                    <p class="text-muted mb-0">منتجات نشطة</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card animated-card">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-success mb-2"></i>
                    <h3>{{ $viewsCount }}</h3>
                    <p class="text-muted mb-0">المشاهدات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card animated-card">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3>{{ $recentProducts->count() }}</h3>
                    <p class="text-muted mb-0">منتجات حديثة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- البطاقات الرئيسية -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="animated-card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>إضافة منتج جديد</h5>
                </div>
                <div class="card-body text-center p-4">
                    <i class="fas fa-recycle fa-4x text-success mb-3"></i>
                    <p class="text-muted">أضف منتجاً مستعملاً للبيع في السوق</p>
                    <a href="{{ route('products.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>إضافة منتج مستعمل
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="animated-card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>إدارة منتجاتي</h5>
                </div>
                <div class="card-body text-center p-4">
                    <i class="fas fa-boxes fa-4x text-primary mb-3"></i>
                    <p class="text-muted">عرض وإدارة جميع منتجاتك المستعملة</p>
                    <a href="{{ route('user.products') }}" class="btn btn-primary">
                        <i class="fas fa-cog me-1"></i>إدارة المنتجات
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="animated-card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>ملفي الشخصي</h5>
                </div>
                <div class="card-body text-center p-4">
                    <i class="fas fa-user-circle fa-4x text-info mb-3"></i>
                    <p class="text-muted">تعديل معلومات حسابك الشخصي</p>
                    <a href="#" class="btn btn-info">
                        <i class="fas fa-edit me-1"></i>تعديل الملف
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="animated-card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>طلباتي</h5>
                </div>
                <div class="card-body text-center p-4">
                    <i class="fas fa-shopping-bag fa-4x text-warning mb-3"></i>
                    <p class="text-muted">عرض وتتبع طلبات الشراء الخاصة بي</p>
                    <a href="#" class="btn btn-warning">
                        <i class="fas fa-eye me-1"></i>عرض الطلبات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات الأخيرة -->
    @if($recentProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card animated-card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>أحدث منتجاتك</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($recentProducts as $product)
                        <div class="col-md-4 mb-3">
                            <div class="card product-card h-100">
                                @if($product->images)
                                    @php
                                        $images = json_decode($product->images);
                                        $firstImage = $images[0] ?? null;
                                    @endphp
                                    @if($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                                    @endif
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="card-text text-success">{{ number_format($product->price) }} ل.س</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                        </span>
                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.stat-card {
    border: none;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.animated-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection
