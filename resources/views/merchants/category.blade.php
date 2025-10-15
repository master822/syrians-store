@extends('layouts.app')

@section('title', 'تجار ' . $categoryName)

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center section-title gradient-text">🏪 تجار {{ $categoryName }}</h1>
            <p class="text-center text-muted">تعرف على أفضل التجار المتخصصين في {{ $categoryName }}</p>
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
                            <i class="fas fa-store fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $merchant->name }}</h5>
                    <div class="merchant-stats mb-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-box me-1"></i>
                            {{ $merchant->products_count }} منتج
                        </span>
                    </div>
                    <div class="merchant-category mb-3">
                        <span class="badge bg-secondary">
                            @switch($categoryName)
                                @case('ملابس') 👕 @break
                                @case('إلكترونيات') 📱 @break
                                @case('أدوات منزلية') 🏠 @break
                                @case('بقالة') 🍎 @break
                            @endswitch
                            {{ $categoryName }}
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
            <h4 class="text-muted">لا توجد تجار في {{ $categoryName }} حالياً</h4>
            <p class="text-muted">يمكنك استعراض الأقسام الأخرى أو العودة لاحقاً</p>
            <a href="{{ url('/merchants') }}" class="btn btn-modern">استعراض جميع التجار</a>
        </div>
    @endif
</div>
@endsection
