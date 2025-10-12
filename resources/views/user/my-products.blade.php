@extends('layouts.app')

@section('title', 'منتجاتي المستعملة')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="section-title gradient-text">🔄 منتجاتي المستعملة</h1>
                <a href="{{ route('products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>إضافة منتج مستعمل
                </a>
            </div>
            <p class="text-muted">إدارة المنتجات المستعملة التي أضفتها</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
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
                                    <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                                
                                @if($product->condition)
                                    <div class="mb-2">
                                        <small class="text-muted">الحالة: {{ $product->condition }}</small>
                                    </div>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        المشاهدات: {{ $product->views }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $product->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i>عرض
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm flex-fill">
                                        <i class="fas fa-edit me-1"></i>تعديل
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            <i class="fas fa-trash me-1"></i>حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">لا توجد منتجات مستعملة</h3>
                <p class="text-muted">لم تقم بإضافة أي منتجات مستعملة بعد</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>أضف أول منتج مستعمل
                </a>
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
