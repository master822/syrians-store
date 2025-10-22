@extends('layouts.app')

@section('title', 'جميع التجار')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center section-title gradient-text">🏪 جميع التجار</h1>
            <p class="text-center text-muted">تعرف على أفضل التجار في منصتنا</p>
        </div>
    </div>

    @if($merchants->count() > 0)
        <div class="row">
            @foreach($merchants as $merchant)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="animated-card text-center p-4">
                    <div class="merchant-avatar mb-3">
                        <div class="rounded-circle bg-primary-gradient d-inline-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px;">
                            <i > <div class="merchant-avatar mb-3">
                        <img src="{{ $merchant->getAvatarUrlAttribute() }}" 
                             class="merchant-img , rounded-circle" 
                             alt="{{ $merchant->name }}">
                        <div class="online-status bg-success"></div>
                    </div></i>
                           
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $merchant->name }}</h5>
                    <div class="merchant-stats mb-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-box me-1"></i>
                            {{ $merchant->products_count }} منتج
                        </span>
                    </div>
                    <a href="{{ url('/products') }}?merchant={{ $merchant->id }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        استعرض منتجات التاجر
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12">
                {{ $merchants->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-store fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد تجار مسجلين حالياً</h4>
            <p class="text-muted">كن أول تاجر في منصتنا!</p>
            <a href="{{ route('register') }}" class="btn btn-modern">سجل كتاجر</a>
        </div>
    @endif
</div>
@endsection
