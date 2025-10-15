@extends('layouts.app')

@section('title', 'إنشاء تخفيض جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="elite-card p-4">
                <h4 class="text-center mb-4 text-dark">إنشاء تخفيض جديد</h4>
                
                <form action="{{ route('merchant.discounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">نسبة التخفيض (%) *</label>
                        <input type="number" name="discount_percentage" class="form-control" 
                               min="1" max="100" value="{{ old('discount_percentage') }}" required
                               style="color: #000000; background-color: #ffffff; border: 2px solid #d1d5db;">
                        <small class="text-muted">أدخل نسبة التخفيض من 1% إلى 100%</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">مدة التخفيض (أيام) *</label>
                        <input type="number" name="discount_duration" class="form-control" 
                               min="1" value="{{ old('discount_duration') }}" required
                               style="color: #000000; background-color: #ffffff; border: 2px solid #d1d5db;">
                        <small class="text-muted">عدد أيام فعالية التخفيض</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">صور التخفيض (اختياري)</label>
                        <input type="file" name="discount_images[]" class="form-control" multiple accept="image/*"
                               style="color: #000000; background-color: #ffffff; border: 2px solid #d1d5db;">
                        <small class="text-muted">يمكنك رفع حتى 3 صور للتخفيض</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">اختر المنتجات *</label>
                        <div class="products-list border rounded p-3" style="max-height: 200px; overflow-y: auto; background-color: #ffffff;">
                            @foreach(Auth::user()->products()->where('is_used', false)->where('is_active', true)->get() as $product)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="products[]" 
                                       value="{{ $product->id }}" id="product{{ $product->id }}"
                                       style="color: #000000;">
                                <label class="form-check-label text-dark" for="product{{ $product->id }}">
                                    {{ $product->name }} - {{ number_format($product->price, 2) }} ر.س
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <small class="text-muted">اختر المنتجات التي تريد تطبيق التخفيض عليها</small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">تطبيق التخفيض</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
