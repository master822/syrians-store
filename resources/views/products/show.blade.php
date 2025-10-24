@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <!-- معرض الصور -->
            <div class="card">
                <div class="card-body">
                    @if($product->images)
                        @php
                            $images = json_decode($product->images);
                            $firstImage = $images[0] ?? null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $product->name }}"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        @else
                            <div class="text-center py-5 bg-light rounded">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="text-muted mt-2">لا توجد صورة</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fas fa-image fa-3x text-muted"></i>
                            <p class="text-muted mt-2">لا توجد صورة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 text-primary">{{ $product->name }}</h1>
                    
                    @if($product->is_used)
                        <span class="badge bg-warning text-dark mb-3">منتج مستعمل</span>
                        @if($product->condition)
                            <span class="badge bg-info mb-3">الحالة: {{ $product->condition }}</span>
                        @endif
                    @else
                        <span class="badge bg-success mb-3">منتج جديد</span>
                    @endif

                    @if($product->discount_percentage > 0)
                        <div class="price-section mb-3">
                            <span class="text-danger fw-bold fs-3">
                                {{ number_format($product->price - ($product->price * $product->discount_percentage / 100), 2) }} TL
                            </span>
                            <small class="text-muted text-decoration-line-through d-block fs-5">
                                {{ number_format($product->price, 2) }} TL
                            </small>
                            <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                        </div>
                    @else
                        <div class="price-section mb-3">
                            <span class="fw-bold text-primary fs-3">{{ number_format($product->price, 2) }} TL</span>
                        </div>
                    @endif

                    <div class="product-meta mb-4">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ $product->views }} مشاهدة
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $product->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-dark">الوصف:</h5>
                    <p class="text-muted mb-4">{{ $product->description }}</p>

                    <!-- معلومات البائع -->
                    <div class="seller-info card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title">معلومات البائع:</h6>
                            <div class="d-flex align-items-center">
                                @if($product->user->avatar)
                                    <img src="{{ asset('storage/' . $product->user->avatar) }}" 
                                         alt="{{ $product->user->name }}" 
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $product->user->name }}</h6>
                                    @if($product->user->user_type === 'merchant')
                                        <p class="text-muted mb-1 small">{{ $product->user->store_name }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-store me-1"></i>تاجر
                                        </small>
                                    @else
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>مستخدم عادي
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر التواصل -->
                    @auth
                        @if(Auth::id() !== $product->user_id)
                            <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                                <i class="fas fa-envelope me-2"></i>
                                @if($product->user->user_type === 'merchant')
                                    تواصل مع التاجر
                                @else
                                    تواصل مع البائع
                                @endif
                            </button>
                        @endif

                        @if($canEdit)
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>تعديل المنتج
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        <i class="fas fa-trash me-2"></i>حذف المنتج
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>سجل الدخول للتواصل مع البائع
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المشابهة -->
    @if($similarProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-primary mb-4">منتجات مشابهة</h3>
            <div class="row">
                @foreach($similarProducts as $similarProduct)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        @if($similarProduct->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">خصم {{ $similarProduct->discount_percentage }}%</span>
                            </div>
                        @endif
                        
                        @if($similarProduct->is_used)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-warning text-dark">مستعمل</span>
                            </div>
                        @endif

                        <div class="card-img-container" style="height: 200px;">
                            @if($similarProduct->images)
                                @php
                                    $similarImages = json_decode($similarProduct->images);
                                    $similarFirstImage = $similarImages[0] ?? null;
                                @endphp
                                @if($similarFirstImage)
                                    <img src="{{ asset('storage/' . $similarFirstImage) }}" 
                                         class="card-img-top product-image" 
                                         alt="{{ $similarProduct->name }}"
                                         style="height: 100%; object-fit: cover;">
                                @endif
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($similarProduct->name, 50) }}</h6>
                            
                            <div class="price-section">
                                @if($similarProduct->discount_percentage > 0)
                                    @php
                                        $similarDiscountedPrice = $similarProduct->price - ($similarProduct->price * $similarProduct->discount_percentage / 100);
                                    @endphp
                                    <span class="text-danger fw-bold">{{ number_format($similarDiscountedPrice, 2) }} TL</span>
                                    <small class="text-muted text-decoration-line-through d-block">{{ number_format($similarProduct->price, 2) }} TL</small>
                                @else
                                    <span class="fw-bold text-primary">{{ number_format($similarProduct->price, 2) }} TL</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('products.show', $similarProduct->id) }}" class="btn btn-outline-primary w-100 btn-sm">
                                <i class="fas fa-eye me-2"></i>عرض
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal التواصل -->
@auth
@if(Auth::id() !== $product->user_id)
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">
                    <i class="fas fa-envelope me-2"></i>
                    @if($product->user->user_type === 'merchant')
                        تواصل مع التاجر
                    @else
                        تواصل مع البائع
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="@if($product->user->user_type === 'merchant') {{ route('messages.contact', $product->id) }} @else {{ route('messages.contact-seller', $product->id) }} @endif" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message" class="form-label">رسالتك:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" 
                                  placeholder="اكتب رسالتك هنا..." required></textarea>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            ستتم إضافة رسالتك إلى محادثتك مع {{ $product->user->name }} ويمكنك متابعتها من صفحة الرسائل.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>إرسال الرسالة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<style>
.product-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.card-img-container {
    overflow: hidden;
    border-radius: 8px 8px 0 0;
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

.seller-info {
    border-left: 4px solid #6366f1;
}
</style>
@endsection
