@extends('layouts.app')

@section('title', 'التخفيضات - لوحة المتجر')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="modern-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-primary mb-0">إدارة التخفيضات</h4>
                    <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary">
                        <i class="fas fa-tag me-2"></i>إنشاء تخفيض جديد
                    </a>
                </div>

                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="modern-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="text-dark mb-0">{{ $product->name }}</h6>
                                        <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
                                    </div>
                                    
                                    @if($product->images)
                                        @php
                                            $images = json_decode($product->images);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 class="img-fluid rounded mb-3" 
                                                 alt="{{ $product->name }}"
                                                 style="height: 150px; width: 100%; object-fit: cover;">
                                        @endif
                                    @endif
                                    
                                    <div class="price-section mb-3">
                                        @php
                                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                        @endphp
                                        <span class="text-danger fw-bold fs-5">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                        <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('merchant.discounts.edit', $product->id) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit me-1"></i>تعديل
                                        </a>
                                        <form action="{{ route('merchant.discounts.remove', $product->id) }}" 
                                              method="POST"
                                              onsubmit="return confirm('هل أنت متأكد من إزالة التخفيض؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
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
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark">لا توجد تخفيضات</h5>
                        <p class="text-muted mb-4">لم تقم بإنشاء أي تخفيضات بعد</p>
                        <a href="{{ route('merchant.discounts.create') }}" class="btn btn-primary">
                            <i class="fas fa-tag me-2"></i>إنشاء أول تخفيض
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
