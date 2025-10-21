@extends('layouts.app')

@section('title', 'تعديل التخفيض - لوحة تحكم التاجر')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل التخفيض
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('merchant.discounts.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- معلومات المنتج -->
                        <div class="mb-4">
                            <h6 class="text-primary">معلومات المنتج:</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    @if($product->images)
                                        @php
                                            $images = json_decode($product->images);
                                            $firstImage = $images[0] ?? null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                 class="img-fluid rounded"
                                                 alt="{{ $product->name }}">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h5>{{ $product->name }}</h5>
                                    <p class="text-muted">{{ $product->description }}</p>
                                    <p><strong>السعر الأصلي:</strong> {{ number_format($product->price, 2) }} ر.س</p>
                                </div>
                            </div>
                        </div>

                        <!-- نسبة التخفيض -->
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">نسبة التخفيض (%) *</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="discount_percentage" 
                                   name="discount_percentage" 
                                   value="{{ old('discount_percentage', $product->discount_percentage) }}"
                                   min="1" 
                                   max="100" 
                                   required>
                            @error('discount_percentage')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الصور الحالية -->
                        @if($product->discount_images)
                            <div class="mb-3">
                                <label class="form-label">الصور الحالية:</label>
                                <div class="row">
                                    @foreach(json_decode($product->discount_images) as $index => $image)
                                    <div class="col-md-4 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 class="img-thumbnail"
                                                 style="width: 100%; height: 150px; object-fit: cover;">
                                            <div class="form-check position-absolute top-0 start-0 m-2">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       name="delete_images[]" 
                                                       value="{{ $image }}"
                                                       id="delete_image_{{ $index }}">
                                                <label class="form-check-label text-white" for="delete_image_{{ $index }}">
                                                    حذف
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- إضافة صور جديدة -->
                        <div class="mb-3">
                            <label for="discount_images" class="form-label">إضافة صور جديدة (اختياري)</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="discount_images" 
                                   name="discount_images[]" 
                                   multiple 
                                   accept="image/*">
                            <div class="form-text">
                                يمكنك رفع حتى 3 صور. الصور الحالية: {{ $product->discount_images ? count(json_decode($product->discount_images)) : 0 }}/3
                            </div>
                            @error('discount_images.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معاينة السعر بعد التخفيض -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="text-success">معاينة السعر بعد التخفيض:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">السعر الأصلي: <span class="text-decoration-line-through">{{ number_format($product->price, 2) }} ر.س</span></p>
                                    <p class="mb-1">نسبة التخفيض: <span id="preview_percentage">{{ old('discount_percentage', $product->discount_percentage) }}%</span></p>
                                    <p class="mb-0 fw-bold">السعر بعد التخفيض: <span id="preview_price" class="text-success">{{ number_format($product->price - ($product->price * old('discount_percentage', $product->discount_percentage) / 100), 2) }} ر.س</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0 text-muted">التوفير: <span id="preview_saving" class="text-danger">{{ number_format($product->price * old('discount_percentage', $product->discount_percentage) / 100, 2) }} ر.س</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('merchant.discounts') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>رجوع
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>تحديث التخفيض
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountInput = document.getElementById('discount_percentage');
    const previewPercentage = document.getElementById('preview_percentage');
    const previewPrice = document.getElementById('preview_price');
    const previewSaving = document.getElementById('preview_saving');
    const originalPrice = {{ $product->price }};

    function updatePreview() {
        const discount = parseFloat(discountInput.value) || 0;
        const saving = originalPrice * discount / 100;
        const finalPrice = originalPrice - saving;

        previewPercentage.textContent = discount + '%';
        previewPrice.textContent = finalPrice.toFixed(2) + ' ر.س';
        previewSaving.textContent = saving.toFixed(2) + ' ر.س';
    }

    discountInput.addEventListener('input', updatePreview);
});
</script>
@endsection
