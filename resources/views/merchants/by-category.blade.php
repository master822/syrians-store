@extends('layouts.app')

@section('title', 'تجار ' . $categoryName)

@section('content')
<div class="container py-4 fade-in">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="section-title gradient-text">تجار {{ $categoryName }}</h1>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('merchants.index') }}" class="btn btn-outline-primary btn-sm">
                        جميع التجار
                    </a>
                    <a href="{{ url('/merchants/category/electronics') }}" class="btn btn-outline-info btn-sm">
                        تجار الإلكترونيات
                    </a>
                    <a href="{{ url('/merchants/category/home') }}" class="btn btn-outline-success btn-sm">
                        تجار الأدوات المنزلية
                    </a>
                </div>
            </div>
            <p class="text-muted mb-4">استعرض أفضل تجار {{ $categoryName }} في منصتنا</p>

            @if($merchants->count() > 0)
                <div class="row">
                    @foreach($merchants as $merchant)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="card merchant-card h-100">
                                <div class="card-body text-center">
                                    <div class="merchant-avatar mb-3">
                                        <i class="fas fa-store fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="card-title">{{ $merchant->store_name }}</h4>
                                    <p class="card-text text-muted mb-3">
                                        {{ $merchant->store_description }}
                                    </p>
                                    
                                    <div class="merchant-info mb-3">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $merchant->store_city }}
                                                </small>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-phone me-1"></i>
                                                    {{ $merchant->store_phone }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="merchant-stats mb-3">
                                        @php
                                            $productCount = \App\Models\Product::where('user_id', $merchant->id)
                                                ->where('status', 'active')
                                                ->count();
                                        @endphp
                                        <div class="row text-center">
                                            <div class="col-12">
                                                <span class="badge bg-info">
                                                    {{ $productCount }} منتج
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('merchants.show', $merchant->id) }}" class="btn btn-primary btn-sm">
                                            زيارة المتجر
                                        </a>
                                        <a href="{{ route('products.byCategory', $category) }}" class="btn btn-outline-primary btn-sm">
                                            عرض المنتجات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $merchants->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-store fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">لا توجد تجار في هذا التصنيف حالياً</h3>
                        <p class="text-muted mb-4">كن أول تاجر في تصنيف {{ $categoryName }}!</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            سجل كتاجر
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.merchant-card {
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.merchant-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    border-color: var(--primary-red);
}

.merchant-avatar {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--primary-red);
}

.empty-state {
    padding: 3rem 1rem;
}

@media (max-width: 768px) {
    .container {
        padding: 0.5rem;
    }
    
    .section-title {
        font-size: 1.4rem;
        text-align: center;
    }
    
    .merchant-card .card-body {
        padding: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .merchant-info .row,
    .merchant-stats .row {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
@endsection
