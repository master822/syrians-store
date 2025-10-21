@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="modern-card">
                <div class="card-img-container">
                    @if($product->images)
                        @php
                            $images = json_decode($product->images);
                            $firstImage = $images[0] ?? null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                 class="card-product-image" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="no-image-placeholder">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="modern-card p-4">
                @if($product->discount_percentage > 0)
                    <div class="mb-3">
                        <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                    </div>
                @endif
                
                <h1 class="text-primary mb-3">{{ $product->name }}</h1>
                
                <div class="price-section mb-4">
                    @if($product->discount_percentage > 0)
                        @php
                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                        @endphp
                        <h2 class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} ر.س</h2>
                        <h4 class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }} ر.س</h4>
                    @else
                        <h2 class="text-primary fw-bold">{{ number_format($product->price, 2) }} ر.س</h2>
                    @endif
                </div>
                
                <div class="product-details mb-4">
                    <p class="text-muted mb-3">{{ $product->description }}</p>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>التصنيف:</strong>
                            <br>
                            <span class="text-muted">{{ $product->category->name ?? 'غير محدد' }}</span>
                        </div>
                        <div class="col-6">
                            <strong>النوع:</strong>
                            <br>
                            <span class="text-muted">
                                @if($product->is_used)
                                    <span class="badge bg-info">🔄 منتج مستعمل</span>
                                @else
                                    <span class="badge bg-success">🆕 منتج جديد</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    @if($product->is_used && $product->condition)
                        <div class="mb-3">
                            <strong>الحالة:</strong>
                            <br>
                            <span class="text-muted">{{ $product->condition }}</span>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <strong>المشاهدات:</strong>
                        <br>
                        <span class="text-muted">{{ $product->views }} مشاهدة</span>
                    </div>
                </div>
                
                <div class="seller-info mb-4 p-3 bg-light rounded">
                    <h5 class="mb-3">معلومات البائع</h5>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $product->user->name }}</h6>
                            <p class="text-muted mb-0 small">
                                <i class="fas fa-store me-1"></i>
                                @if($product->user->store_name)
                                    {{ $product->user->store_name }}
                                @else
                                    بائع
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('merchants.show', $product->user->id) }}" class="btn btn-outline-primary btn-sm">
                            زيارة المتجر
                        </a>
                    </div>
                </div>
                
                <div class="product-actions">
                    @auth
                        @if(auth()->id() !== $product->user_id)
                            <!-- زر التواصل مع البائع (للمستخدمين الآخرين) -->
                            <button class="btn btn-primary btn-lg w-100 mb-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                                <i class="fas fa-envelope me-2"></i>تواصل مع البائع
                            </button>
                        @else
                            <!-- أزرار التعديل والحذف (للمالك فقط) -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning flex-fill">
                                    <i class="fas fa-edit me-2"></i>تعديل المنتج
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" 
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        <i class="fas fa-trash me-2"></i>حذف المنتج
                                    </button>
                                </form>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted">أنت مالك هذا المنتج</small>
                            </div>
                        @endif
                    @else
                        <!-- زر تسجيل الدخول للزوار -->
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>سجل الدخول للتواصل مع البائع
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج التواصل -->
@auth
@if(auth()->id() !== $product->user_id)
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تواصل مع {{ $product->user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('messages.contact', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">رسالتك</label>
                        <textarea name="message" class="form-control" rows="4" 
                                  placeholder="اكتب رسالتك هنا..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال الرسالة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.card-img-container {
    height: 400px;
    overflow: hidden;
    border-radius: 15px 15px 0 0;
}

.card-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image-placeholder {
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
}

.price-section {
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 1rem;
}

.seller-info {
    border-left: 4px solid #6366f1;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1.1rem;
}
</style>
@endsection
