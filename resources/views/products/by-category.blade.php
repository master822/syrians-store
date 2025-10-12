@extends('layouts.app')

@section('title', 'منتجات ' . $category->name)

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="section-title gradient-text">
                        <i class="{{ $category->icon }} me-2"></i>{{ $category->name }}
                    </h1>
                    <p class="text-muted">استعرض جميع المنتجات في تصنيف {{ $category->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                        جميع المنتجات
                    </a>
                    <a href="{{ route('products.new') }}" class="btn btn-outline-success">
                        منتجات جديدة
                    </a>
                    <a href="{{ route('products.used') }}" class="btn btn-outline-warning">
                        منتجات مستعملة
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
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
                <i class="{{ $category->icon }} fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">لا توجد منتجات في هذا التصنيف</h3>
                <p class="text-muted">كن أول من يضيف منتج في تصنيف {{ $category->name }}</p>
                @auth
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        أضف منتج جديد
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        سجل الآن وأضف منتجك
                    </a>
                @endauth
            </div>
        </div>
    @endif
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: var(--accent-color);
}

.empty-state {
    padding: 3rem 1rem;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection
