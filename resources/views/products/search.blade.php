@extends('layouts.app')

@section('title', 'بحث في المنتجات')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <!-- شريط التصفية -->
            <div class="elite-card p-4 mb-4">
                <h5 class="text-gold mb-4">تصفية النتائج</h5>
                
                <form action="{{ route('products.search') }}" method="GET">
                    <!-- البحث النصي -->
                    <div class="mb-3">
                        <label class="form-label text-light">كلمة البحث</label>
                        <input type="text" name="query" class="form-control bg-dark text-light border-secondary" 
                               value="{{ $query }}" placeholder="ابحث عن منتج...">
                    </div>
                    
                    <!-- نطاق السعر -->
                    <div class="mb-3">
                        <label class="form-label text-light">نطاق السعر</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control bg-dark text-light border-secondary" 
                                       placeholder="الحد الأدنى" value="{{ $minPrice }}">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control bg-dark text-light border-secondary" 
                                       placeholder="الحد الأقصى" value="{{ $maxPrice }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- التصنيف -->
                    <div class="mb-3">
                        <label class="form-label text-light">التصنيف</label>
                        <select name="category_id" class="form-select bg-dark text-light border-secondary">
                            <option value="">جميع التصنيفات</option>
                            @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- نوع المنتج -->
                    <div class="mb-3">
                        <label class="form-label text-light">نوع المنتج</label>
                        <select name="product_type" class="form-select bg-dark text-light border-secondary">
                            <option value="">جميع المنتجات</option>
                            <option value="new" {{ $productType == 'new' ? 'selected' : '' }}>منتجات جديدة</option>
                            <option value="used" {{ $productType == 'used' ? 'selected' : '' }}>منتجات مستعملة</option>
                        </select>
                    </div>
                    
                    <!-- الترتيب -->
                    <div class="mb-3">
                        <label class="form-label text-light">ترتيب حسب</label>
                        <select name="sort" class="form-select bg-dark text-light border-secondary">
                            <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>الأحدث</option>
                            <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                            <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>السعر: منخفض إلى مرتفع</option>
                            <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>السعر: مرتفع إلى منخفض</option>
                            <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>الاسم</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100">تطبيق التصفية</button>
                </form>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- نتائج البحث -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-gold mb-0">نتائج البحث</h4>
                <span class="text-light">عرض {{ $products->total() }} منتج</span>
            </div>
            
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="elite-card h-100">
                            @if($product->discount_percentage > 0)
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger">خصم {{ $product->discount_percentage }}%</span>
                                </div>
                            @endif
                            
                            <div class="card-img-top position-relative overflow-hidden">
                                @if($product->images)
                                    @php
                                        $images = json_decode($product->images);
                                        $firstImage = $images[0] ?? null;
                                    @endphp
                                    @if($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage) }}" 
                                             class="img-fluid" 
                                             alt="{{ $product->name }}"
                                             style="height: 200px; width: 100%; object-fit: cover;">
                                    @endif
                                @endif
                            </div>
                            
                            <div class="card-body">
                                <h6 class="card-title text-light">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="price-section mb-2">
                                    @if($product->discount_percentage > 0)
                                        @php
                                            $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                        @endphp
                                        <span class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                        <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                    @else
                                        <span class="fw-bold text-light">{{ number_format($product->price, 2) }} ر.س</span>
                                    @endif
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span>
                                        <i class="fas fa-store"></i>
                                        {{ $product->user->name }}
                                    </span>
                                    <span>
                                        <i class="fas fa-eye"></i>
                                        {{ $product->views }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                                    عرض المنتج
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
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-light">لا توجد نتائج</h4>
                    <p class="text-muted">لم نعثر على أي منتجات تطابق بحثك</p>
                    <a href="{{ route('products.index') }}" class="btn btn-warning">عرض جميع المنتجات</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
