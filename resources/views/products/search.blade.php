@extends('layouts.app')

@section('title', 'نتائج البحث')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="section-title gradient-text">🔍 نتائج البحث</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#advancedSearchModal">
                    <i class="fas fa-search-plus me-1"></i>بحث متقدم
                </button>
            </div>

            <!-- Search Filters Summary -->
            @if($query || $minPrice || $maxPrice || $categoryId || $productType)
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="card-title">فلاتر البحث المطبقة:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if($query)
                        <span class="badge bg-primary">كلمة: "{{ $query }}"</span>
                        @endif
                        @if($minPrice)
                        <span class="badge bg-success">من: {{ number_format($minPrice) }} ل.س</span>
                        @endif
                        @if($maxPrice)
                        <span class="badge bg-success">إلى: {{ number_format($maxPrice) }} ل.س</span>
                        @endif
                        @if($categoryId)
                        @php $category = \App\Models\Category::find($categoryId); @endphp
                        @if($category)
                        <span class="badge bg-info">تصنيف: {{ $category->name }}</span>
                        @endif
                        @endif
                        @if($productType === 'new')
                        <span class="badge bg-warning">🆕 منتجات جديدة</span>
                        @elseif($productType === 'used')
                        <span class="badge bg-warning">🔄 منتجات مستعملة</span>
                        @endif
                        <a href="{{ route('products.search') }}" class="badge bg-danger text-decoration-none">مسح الكل</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100">
                        @if($product->images)
                            @php
                                $images = json_decode($product->images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">لا توجد صورة</span>
                                </div>
                            @endif
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted">لا توجد صورة</span>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h5 text-success">{{ number_format($product->price) }} ل.س</span>
                                    <span class="badge {{ $product->is_used ? 'bg-warning' : 'bg-success' }}">
                                        {{ $product->is_used ? '🔄 مستعمل' : '🆕 جديد' }}
                                    </span>
                                </div>
                                
                                @if($product->is_used && $product->condition)
                                    <div class="mb-2">
                                        <small class="text-muted">الحالة: {{ $product->condition }}</small>
                                    </div>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ $product->user->name }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $product->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm w-100 mt-2">
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">لا توجد نتائج للبحث</h3>
                <p class="text-muted">لم نتمكن من العثور على منتجات تطابق معايير البحث الخاصة بك</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">عرض جميع المنتجات</a>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#advancedSearchModal">
                        تجربة بحث أخرى
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.empty-state {
    padding: 3rem 1rem;
}
</style>
@endsection
