@extends('layouts.app')

@section('title', 'بحث عن المنتجات')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- شريط البحث الجانبي -->
        <div class="col-lg-3 mb-4">
            <div class="card animated-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>تصفية النتائج</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.search') }}" method="GET">
                        <!-- البحث النصي -->
                        <div class="mb-3">
                            <label class="form-label">كلمة البحث</label>
                            <input type="text" name="query" class="form-control" value="{{ $query }}" 
                                   placeholder="ابحث عن منتج...">
                        </div>

                        <!-- نطاق السعر -->
                        <div class="mb-3">
                            <label class="form-label">نطاق السعر</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" 
                                           placeholder="الحد الأدنى" value="{{ $minPrice }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" 
                                           placeholder="الحد الأقصى" value="{{ $maxPrice }}">
                                </div>
                            </div>
                        </div>

                        <!-- التصنيف -->
                        <div class="mb-3">
                            <label class="form-label">التصنيف</label>
                            <select name="category_id" class="form-select">
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
                            <label class="form-label">نوع المنتج</label>
                            <select name="product_type" class="form-select">
                                <option value="">جميع الأنواع</option>
                                <option value="new" {{ $productType === 'new' ? 'selected' : '' }}>منتجات جديدة</option>
                                <option value="used" {{ $productType === 'used' ? 'selected' : '' }}>منتجات مستعملة</option>
                            </select>
                        </div>

                        <!-- الترتيب -->
                        <div class="mb-3">
                            <label class="form-label">ترتيب حسب</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>الأحدث</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>الأقدم</option>
                                <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>السعر: من الأقل</option>
                                <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>السعر: من الأعلى</option>
                                <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>الاسم</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>تطبيق الفلتر
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- نتائج البحث -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">
                    <i class="fas fa-search me-2"></i>
                    نتائج البحث
                    @if($query)
                        <small class="text-muted">عن "{{ $query }}"</small>
                    @endif
                </h4>
                <span class="text-muted">عرض {{ $products->total() }} منتج</span>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="card product-card animated-card h-100">
                            @if($product->discount_percentage > 0)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-danger pulse-animation">خصم {{ $product->discount_percentage }}%</span>
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
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="price-section">
                                        @if($product->discount_percentage > 0)
                                            @php
                                                $discountedPrice = $product->price - ($product->price * $product->discount_percentage / 100);
                                            @endphp
                                            <span class="text-danger fw-bold">{{ number_format($discountedPrice, 2) }} ر.س</span>
                                            <small class="text-muted text-decoration-line-through d-block">{{ number_format($product->price, 2) }} ر.س</small>
                                        @else
                                            <span class="fw-bold text-dark">{{ number_format($product->price, 2) }} ر.س</span>
                                        @endif
                                    </div>
                                    <span class="badge bg-light text-dark">
                                        @if($product->is_used)
                                            مستعمل
                                        @else
                                            جديد
                                        @endif
                                    </span>
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
                    <h4 class="text-muted">لم نعثر على نتائج</h4>
                    <p class="text-muted">جرب تعديل معايير البحث أو استخدم كلمات أخرى</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        استعراض جميع المنتجات
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
