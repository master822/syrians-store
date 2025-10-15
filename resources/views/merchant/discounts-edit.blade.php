@extends('layouts.app')

@section('title', 'تعديل التخفيض')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="animated-card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>تعديل التخفيض</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('merchant.discounts.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">اسم المنتج</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
                                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" 
                                       value="{{ old('discount_percentage', $product->discount_percentage) }}" min="1" max="100" required>
                                @error('discount_percentage')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="discount_duration" class="form-label">مدة التخفيض (أيام)</label>
                                <input type="number" class="form-control" id="discount_duration" name="discount_duration" 
                                       value="{{ old('discount_duration', 7) }}" min="1" required>
                                @error('discount_duration')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- الصور الحالية -->
                        @if($product->discount_images)
                            @php
                                $images = json_decode($product->discount_images, true);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">صور التخفيض الحالية</label>
                                <div class="row">
                                    @foreach($images as $index => $image)
                                        <div class="col-md-4 mb-2">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover;">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image }}" id="deleteImage{{ $index }}">
                                                    <label class="form-check-label text-danger small" for="deleteImage{{ $index }}">
                                                        حذف الصورة
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
                            <label for="discount_images" class="form-label">إضافة صور جديدة للتخفيض (اختياري)</label>
                            <input type="file" class="form-control" id="discount_images" name="discount_images[]" multiple accept="image/*">
                            <div class="form-text">يمكنك رفع حتى 3 صور. الصيغ المدعومة: JPEG, PNG, JPG, GIF</div>
                            @error('discount_images.*')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url('/merchant/discounts') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-1"></i>رجوع
                            </a>
                            <div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- إزالة التخفيض -->
                    <hr class="my-4">
                    <div class="text-center">
                        <form action="{{ route('merchant.discounts.remove', $product->id) }}" method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من إزالة التخفيض من هذا المنتج؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-tag me-1"></i>إزالة التخفيض
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
