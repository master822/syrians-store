@extends('layouts.app')

@section('title', 'إدارة التخفيضات - Merchanta')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-primary">إدارة التخفيضات</h1>
                <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>إضافة تخفيض جديد
                </a>
            </div>
            <p class="text-muted">إدارة التخفيضات والعروض الخاصة بمنتجاتك</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            @if($product->discount_percentage > 0)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                                </div>
                            @endif
                            
                            <div class="card-img-container" style="height: 200px; overflow: hidden;">
                                <img src="{{ $product->first_image }}" 
                                     class="card-img-top h-100" 
                                     alt="{{ $product->name }}"
                                     style="object-fit: cover;">
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <div class="price-section mb-3">
                                @if($product->discount_percentage > 0)
                                    @php
                                        $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                    @endphp
                                    <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} TL</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} TL</small>
                                @else
                                    <span class="fw-bold text-primary fs-5">{{ number_format($product->price, 2) }} TL</span>
                                @endif
                            </div>

                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('merchant.discounts.edit', $product->id) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmRemove('{{ $product->id }}', '{{ $product->name }}')">
                                    <i class="fas fa-trash me-1"></i>إزالة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد تخفيضات حالياً</h4>
                    <p class="text-muted mb-4">يمكنك إضافة تخفيضات جديدة على منتجاتك</p>
                    <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>إضافة أول تخفيض
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- نموذج تأكيد الحذف -->
<div class="modal fade" id="removeDiscountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد إزالة التخفيض</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من أنك تريد إزالة التخفيض من المنتج: <strong id="productName"></strong>؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="removeDiscountForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">نعم، إزالة التخفيض</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRemove(productId, productName) {
    document.getElementById('productName').textContent = productName;
    document.getElementById('removeDiscountForm').action = '/merchant/discounts/' + productId;
    new bootstrap.Modal(document.getElementById('removeDiscountModal')).show();
}
</script>

<style>
.card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card-img-container {
    border-radius: 12px 12px 0 0;
    overflow: hidden;
}

.price-section {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
}

.btn-group .btn {
    border-radius: 8px;
}
</style>
@endsection
