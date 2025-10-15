@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="elite-card p-3">
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
                        <div class="bg-dark text-white text-center py-5 rounded">
                            <i class="fas fa-image fa-3x"></i>
                            <p class="mt-2">لا توجد صورة</p>
                        </div>
                    @endif
                @else
                    <div class="bg-dark text-white text-center py-5 rounded">
                        <i class="fas fa-image fa-3x"></i>
                        <p class="mt-2">لا توجد صورة</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="elite-card p-4">
                <h2 class="text-dark mb-3">{{ $product->name }}</h2>
                
                <div class="mb-3">
                    <span class="h4 text-primary">{{ number_format($product->price, 2) }} ر.س</span>
                    @if($product->discount_percentage > 0)
                        <span class="text-danger text-decoration-line-through ms-2">
                            {{ number_format($product->price + ($product->price * $product->discount_percentage / 100), 2) }} ر.س
                        </span>
                        <span class="badge bg-danger ms-2">خصم {{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <strong class="text-dark">التصنيف:</strong>
                    <span class="text-muted">{{ $product->category->name ?? 'غير محدد' }}</span>
                </div>
                
                @if($product->is_used)
                <div class="mb-3">
                    <strong class="text-dark">الحالة:</strong>
                    <span class="text-muted">{{ $product->condition }}</span>
                </div>
                @endif
                
                <div class="mb-4">
                    <strong class="text-dark">الوصف:</strong>
                    <p class="text-dark mt-2">{{ $product->description }}</p>
                </div>
                
                <div class="mb-4">
                    <strong class="text-dark">البائع:</strong>
                    <div class="d-flex align-items-center mt-2">
                        <span class="text-dark">{{ $product->user->name }}</span>
                        @if($product->user->is_merchant)
                            <span class="badge bg-warning ms-2">تاجر</span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-4">
                    <strong class="text-dark">المشاهدات:</strong>
                    <span class="text-muted">{{ $product->views }}</span>
                </div>
                
                @if(Auth::check() && Auth::id() !== $product->user_id)
                <div class="contact-section mt-4">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fas fa-envelope me-2"></i>تواصل مع البائع
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- نافذة التواصل مع البائع -->
@if(Auth::check() && Auth::id() !== $product->user_id)
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">تواصل مع {{ $product->user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('messages.contact', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-dark">رسالتك</label>
                        <textarea name="message" class="form-control" rows="4" 
                                  placeholder="اكتب رسالتك هنا..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إرسال الرسالة</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
