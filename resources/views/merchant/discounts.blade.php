@extends('layouts.app')

@section('title', 'التخفيضات - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-gold">
                    <i class="fas fa-tags me-2"></i>التخفيضات
                </h1>
                <a href="{{ route('merchant.discounts.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus-circle me-2"></i>إضافة تخفيض جديد
                </a>
            </div>
            <p class="text-light">إدارة تخفيضات منتجاتك</p>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات المخفضة</h6>
                            <h4 class="text-aqua mb-0">{{ $products->count() }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-tag fa-2x text-aqua"></i>
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
                            <h6 class="text-muted mb-2">متوسط الخصم</h6>
                            <h4 class="text-warning mb-0">
                                {{ number_format($products->avg('discount_percentage') ?? 0, 1) }}%
                            </h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-percentage fa-2x text-warning"></i>
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
                            <h6 class="text-muted mb-2">إجمالي التوفير</h6>
                            <h4 class="text-success mb-0">
                                {{ number_format($products->sum(function($product) {
                                    return $product->price * $product->discount_percentage / 100;
                                })) }} ل.س
                            </h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
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
                            <h6 class="text-muted mb-2">أعلى خصم</h6>
                            <h4 class="text-danger mb-0">
                                {{ $products->max('discount_percentage') ?? 0 }}%
                            </h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-arrow-up fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة المنتجات المخفضة -->
    <div class="row">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-list me-2"></i>المنتجات المخفضة
                    </h5>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-xl-4 col-lg-6 mb-4">
                                <div class="elite-card h-100 discount-card">
                                    <div class="card-img-top position-relative overflow-hidden">
                                        @if($product->images)
                                            @php
                                                $images = json_decode($product->images);
                                                $firstImage = $images[0] ?? null;
                                            @endphp
                                            @if($firstImage)
                                                <img src="{{ asset('storage/' . $firstImage) }}" 
                                                     class="img-fluid" 
                                                     alt="{{ $product->name }}"
                                                     style="height: 200px; width: 100%; object-fit: cover;">
                                            @else
                                                <div class="bg-dark d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="bg-dark d-flex align-items-center justify-content-center" 
                                                 style="height: 200px;">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title text-light">{{ $product->name }}</h5>
                                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="price-section">
                                                <span class="text-danger fw-bold fs-5">
                                                    {{ number_format($product->price - ($product->price * $product->discount_percentage / 100)) }} ل.س
                                                </span>
                                                <small class="text-muted text-decoration-line-through d-block">
                                                    {{ number_format($product->price) }} ل.س
                                                </small>
                                            </div>
                                            <div class="saving-badge">
                                                <span class="badge bg-success">
                                                    وفر {{ number_format($product->price * $product->discount_percentage / 100) }} ل.س
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                            <span>
                                                <i class="fas fa-eye"></i>
                                                {{ $product->views }} مشاهدة
                                            </span>
                                            <span>
                                                <i class="fas fa-box"></i>
                                                {{ $product->category->name ?? 'غير محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent">
                                        <div class="btn-group w-100" role="group">
                                            <a href="{{ route('products.show', $product->id) }}" 
                                               class="btn btn-primary">
                                                <i class="fas fa-eye me-1"></i>عرض
                                            </a>
                                            <a href="{{ route('merchant.discounts.edit', $product->id) }}" 
                                               class="btn btn-warning">
                                                <i class="fas fa-edit me-1"></i>تعديل
                                            </a>
                                            <form action="{{ route('merchant.discounts.remove', $product->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        onclick="return confirm('هل أنت متأكد من إزالة التخفيض؟')">
                                                    <i class="fas fa-trash me-1"></i>إزالة
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">لا توجد تخفيضات حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإضافة أول تخفيض لجذب المزيد من العملاء</p>
                            <a href="{{ route('merchant.discounts.create') }}" class="btn btn-gold btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>إضافة أول تخفيض
                            </a>
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

.discount-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid var(--dark-border);
}

.discount-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
}

.saving-badge .badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    border-radius: 5px;
    flex: 1;
}

.price-section {
    line-height: 1.2;
}
</style>
@endsection
