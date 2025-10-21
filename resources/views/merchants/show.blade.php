@extends('layouts.app')

@section('title', $merchant->store_name . ' - متجر التاجر')

@section('content')
<div class="container-fluid py-4">
    <!-- رأس المتجر -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            @if($merchant->store_logo)
                                <img src="{{ asset('storage/' . $merchant->store_logo) }}" 
                                     alt="{{ $merchant->store_name }}" 
                                     class="rounded-circle shadow"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center shadow"
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-store fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h1 class="mb-2">{{ $merchant->store_name }}</h1>
                            <p class="mb-2 lead">{{ $merchant->store_description }}</p>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="fas fa-tag me-1"></i>{{ $merchant->store_category_name }}
                                </span>
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $merchant->store_city }}
                                </span>
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="fas fa-phone me-1"></i>{{ $merchant->store_phone }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="rating-section">
                                <div class="display-4 text-warning mb-1">{{ number_format($averageRating, 1) }}</div>
                                <div class="stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating))
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-white-50">({{ $totalRatings }} تقييم)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- محتوى المتجر -->
    <div class="row">
        <!-- معلومات المتجر -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>معلومات المتجر
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-user me-2"></i>صاحب المتجر:</strong>
                        <p class="mb-0">{{ $merchant->name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-tag me-2"></i>التصنيف:</strong>
                        <p class="mb-0">{{ $merchant->store_category_name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-map-marker-alt me-2"></i>المدينة:</strong>
                        <p class="mb-0">{{ $merchant->store_city }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-phone me-2"></i>هاتف المتجر:</strong>
                        <p class="mb-0">{{ $merchant->store_phone }}</p>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-boxes me-2"></i>عدد المنتجات:</strong>
                        <p class="mb-0">{{ $merchant->products_count }} منتج</p>
                    </div>
                </div>
            </div>

            <!-- نموذج التقييم -->
            @auth
                @if(auth()->user()->user_type === 'user')
                <div class="card shadow mt-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-star me-2"></i>تقييم المتجر
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ratings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">التقييم</label>
                                <div class="rating-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                        <label for="star{{ $i }}" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">تعليقك</label>
                                <textarea name="comment" class="form-control" rows="3" 
                                          placeholder="اكتب تعليقك عن المتجر..." required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-paper-plane me-2"></i>إرسال التقييم
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            @endauth
        </div>

        <!-- منتجات المتجر -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-boxes me-2"></i>منتجات المتجر
                    </h6>
                    <span class="badge bg-light text-dark">{{ $products->total() }} منتج</span>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-lg-6 mb-4">
                                <div class="card product-card h-100">
                                    @if($product->images)
                                        @php
                                            $images = json_decode($product->images);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $product->name }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                 style="height: 200px;">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-primary">{{ number_format($product->price, 2) }} ر.س</span>
                                            <span class="badge bg-success">جديد</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                                            <i class="fas fa-eye me-2"></i>عرض المنتج
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- الترقيم -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">لا توجد منتجات في هذا المتجر</h4>
                            <p class="text-muted">سيقوم التاجر بإضافة منتجات قريباً</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.rating-input input {
    display: none;
}

.rating-input .star-label {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-input input:checked ~ .star-label,
.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label {
    color: #ffc107;
}

.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>
@endsection
