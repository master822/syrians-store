@extends('layouts.app')

@section('title', 'التخفيضات والعروض')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center text-primary mb-3">
                @if(isset($category))
                    🎯 تخفيضات {{ $category->name }}
                @else
                    🎯 التخفيضات والعروض الخاصة
                @endif
            </h1>
            <p class="text-center text-muted">استفد من أفضل العروض والتخفيضات الحصرية</p>
        </div>
    </div>

    <!-- فلترة التصنيفات -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">🔍 تصفية حسب التصنيف:</h5>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('discounts') }}" class="d-flex">
                                <select name="category" class="form-select me-2" onchange="this.form.submit()">
                                    <option value="all">جميع التصنيفات</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" 
                                            {{ $selectedCategory == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المخفضة -->
    <div class="row">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <!-- شارة التخفيض -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                        </div>

                        <!-- الصورة -->
                        <div class="card-img-container">
                            <img src="{{ $product->first_image }}" 
                                 class="card-img-top product-image" 
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark">{{ $product->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <!-- السعر -->
                            <div class="price-section mb-2">
                                <span class="text-danger fw-bold fs-4">
                                    {{ number_format($product->discounted_price, 2) }} TL
                                </span>
                                <small class="text-muted text-decoration-line-through d-block">
                                    {{ number_format($product->price, 2) }} TL
                                </small>
                            </div>

                            <!-- معلومات التاجر -->
                            <div class="merchant-info mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-store me-1"></i>
                                    {{ $product->user->name }}
                                </small>
                            </div>

                            <!-- الزر -->
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-primary w-100 mt-auto">
                                <i class="fas fa-eye me-2"></i>عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد تخفيضات حالياً</h4>
                    <p class="text-muted">تفقد لاحقاً للحصول على أفضل العروض</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>تصفح جميع المنتجات
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- الترقيم -->
    @if($products->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card-img-container {
    overflow: hidden;
    border-radius: 12px 12px 0 0;
}

.product-image {
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.price-section {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
}
</style>
@endsection
