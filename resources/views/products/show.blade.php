@extends('layouts.app')

@section('title', $product->name . ' - متجر التخفيضات')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- صور المنتج -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                @if($product->images)
                    @php
                        $images = json_decode($product->images);
                        $mainImage = $images[0] ?? null;
                    @endphp
                    @if($mainImage)
                        <div class="main-image mb-3">
                            <img src="{{ asset('storage/' . $mainImage) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $product->name }}"
                                 id="mainProductImage">
                        </div>
                        @if(count($images) > 1)
                            <div class="image-thumbnails d-flex gap-2">
                                @foreach($images as $index => $image)
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         class="img-thumbnail {{ $index === 0 ? 'active' : '' }}"
                                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                         onclick="changeMainImage('{{ asset('storage/' . $image) }}', this)"
                                         alt="{{ $product->name }}">
                                @endforeach
                            </div>
                        @endif
                    @endif
                @else
                    <div class="no-image text-center py-5 bg-light rounded">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <p class="text-muted">لا توجد صور للمنتج</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- معلومات المنتج -->
        <div class="col-lg-6 mb-4">
            <div class="product-info">
                <h1 class="h2 mb-3">{{ $product->name }}</h1>
                
                @if($product->discount_percentage > 0)
                    <div class="discount-badge mb-3">
                        <span class="badge bg-danger fs-6">خصم {{ $product->discount_percentage }}%</span>
                    </div>
                @endif

                <div class="price-section mb-4">
                    @if($product->discount_percentage > 0)
                        @php
                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                        @endphp
                        <div class="current-price text-danger fw-bold fs-3">
                            {{ number_format($discountedPrice, 2) }} TL
                        </div>
                        <div class="original-price text-muted text-decoration-line-through fs-5">
                            {{ number_format($product->price, 2) }} TL
                        </div>
                    @else
                        <div class="current-price text-primary fw-bold fs-3">
                            {{ number_format($product->price, 2) }} TL
                        </div>
                    @endif
                </div>

                <div class="product-meta mb-4">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">
                                <i class="fas fa-eye me-1"></i>
                                {{ $product->views }} مشاهدة
                            </small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $product->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="description-section mb-4">
                    <h5 class="mb-3">وصف المنتج</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>

                @if($product->is_used)
                    <div class="condition-section mb-4">
                        <h5 class="mb-3">حالة المنتج</h5>
                        <span class="badge bg-info fs-6">{{ $product->condition }}</span>
                    </div>
                @endif

                <!-- معلومات التاجر -->
                <div class="merchant-section mb-4">
                    <h5 class="mb-3">معلومات التاجر</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->user->getAvatarUrlAttribute() }}" 
                                     class="rounded-circle me-3"
                                     style="width: 50px; height: 50px; object-fit: cover;"
                                     alt="{{ $product->user->name }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $product->user->name }}</h6>
                                    @if($product->user->store_name)
                                        <p class="text-muted mb-1">{{ $product->user->store_name }}</p>
                                    @endif
                                    <div class="rating-stars">
                                        @php
                                            $avgRating = $product->user->ratings->avg('rating') ?? 0;
                                            $fullStars = floor($avgRating);
                                            $halfStar = $avgRating - $fullStars >= 0.5;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i == $fullStars + 1 && $halfStar)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted ms-1">({{ $product->user->ratings->count() }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="action-buttons">
                    @auth
                        @if(Auth::user()->user_type === 'user' && $product->user->user_type === 'merchant')
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#contactModal">
                                        <i class="fas fa-envelope me-2"></i>مراسلة التاجر
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                        <i class="fas fa-star me-2"></i>تقييم التاجر
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        @if($canEdit)
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-edit me-2"></i>تعديل المنتج
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            <i class="fas fa-trash me-2"></i>حذف المنتج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <p class="mb-2">للمراسلة أو التقييم، يرجى <a href="{{ route('login') }}">تسجيل الدخول</a></p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- منتجات مشابهة -->
    @if($similarProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">منتجات مشابهة</h3>
            <div class="row">
                @foreach($similarProducts as $similarProduct)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        @if($similarProduct->discount_percentage > 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">خصم {{ $similarProduct->discount_percentage }}%</span>
                            </div>
                        @endif
                        
                        <div class="card-img-container">
                            @if($similarProduct->images)
                                @php
                                    $similarImages = json_decode($similarProduct->images);
                                    $similarFirstImage = $similarImages[0] ?? null;
                                @endphp
                                @if($similarFirstImage)
                                    <img src="{{ asset('storage/' . $similarFirstImage) }}" 
                                         class="card-product-image" 
                                         alt="{{ $similarProduct->name }}">
                                @endif
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $similarProduct->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($similarProduct->description, 50) }}</p>
                            
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
                            <a href="{{ route('products.show', $similarProduct->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>عرض المنتج
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

<!-- مودال مراسلة التاجر -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">مراسلة التاجر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('messages.contact', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="message" class="form-label">رسالتك إلى {{ $product->user->name }}</label>
                        <textarea class="form-control" id="message" name="message" rows="5" 
                                  placeholder="اكتب رسالتك هنا..." required></textarea>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            سيتم إرسال رسالتك إلى التاجر وسيتم إشعاره برسالة جديدة.
                        </small>
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

<!-- مودال تقييم التاجر -->
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تقييم التاجر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="merchant_id" value="{{ $product->user->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">التقييم</label>
                        <div class="rating-stars-input text-center">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">تعليقك (اختياري)</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" 
                                  placeholder="اكتب تعليقك عن التاجر..."></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <small>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            سيتم مراجعة تعليقك قبل النشر للتأكد من خلوه من الكلمات غير اللائقة.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning">إرسال التقييم</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.product-images .main-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

.image-thumbnails .img-thumbnail.active {
    border-color: #6366f1;
}

.rating-stars-input {
    direction: ltr;
    unicode-bidi: bidi-override;
}

.rating-stars-input input[type="radio"] {
    display: none;
}

.rating-stars-input .star-label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-stars-input input[type="radio"]:checked ~ .star-label,
.rating-stars-input .star-label:hover,
.rating-stars-input .star-label:hover ~ .star-label {
    color: #ffc107;
}

.rating-stars-input input[type="radio"]:checked + .star-label {
    color: #ffc107;
}

.card-img-container {
    height: 200px;
    overflow: hidden;
}

.card-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .card-product-image {
    transform: scale(1.05);
}
</style>

<script>
function changeMainImage(src, element) {
    document.getElementById('mainProductImage').src = src;
    
    // إزالة النشاط من جميع الصور المصغرة
    document.querySelectorAll('.image-thumbnails .img-thumbnail').forEach(img => {
        img.classList.remove('active');
    });
    
    // إضافة النشاط للصورة المحددة
    element.classList.add('active');
}

// إدارة نجوم التقييم
document.querySelectorAll('.rating-stars-input input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const stars = document.querySelectorAll('.rating-stars-input .star-label');
        const rating = parseInt(this.value);
        
        stars.forEach((star, index) => {
            if (index >= (5 - rating)) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    });
});
</script>
@endsection
