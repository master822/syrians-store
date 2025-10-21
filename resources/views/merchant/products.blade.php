@extends('layouts.app')

@section('title', 'منتجاتي - لوحة تحكم التاجر')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- الشريط الجانبي -->
        <div class="col-lg-3 mb-4">
            <div class="elite-card">
                <div class="card-body text-center">
                    <div class="merchant-avatar mb-3">
                        <img src="{{ $user->getAvatarUrlAttribute() }}" 
                             class="merchant-img" 
                             alt="{{ $user->name }}">
                    </div>
                    <h5 class="text-gold mb-2">{{ $user->name }}</h5>
                    <p class="text-light mb-3">{{ $user->store_name }}</p>
                </div>
            </div>

            <!-- قائمة التنقل -->
            <div class="elite-card mt-3">
                <div class="card-body">
                    <nav class="nav flex-column merchant-nav">
                        <a class="nav-link" href="{{ route('merchant.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            لوحة التحكم
                        </a>
                        <a class="nav-link active" href="{{ route('merchant.products') }}">
                            <i class="fas fa-box me-2"></i>
                            منتجاتي
                        </a>
                        <a class="nav-link" href="{{ route('merchant.products.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>
                            إضافة منتج جديد
                        </a>
                        <a class="nav-link" href="{{ route('merchant.discounts') }}">
                            <i class="fas fa-tag me-2"></i>
                            التخفيضات
                        </a>
                        <a class="nav-link" href="{{ route('messages.inbox') }}">
                            <i class="fas fa-envelope me-2"></i>
                            الرسائل
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="col-lg-9">
            <!-- رأس الصفحة -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-gold mb-1">منتجاتي</h2>
                    <p class="text-muted mb-0">إدارة منتجات متجرك</p>
                </div>
                <a href="{{ route('merchant.products.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus-circle me-2"></i>
                    إضافة منتج جديد
                </a>
            </div>

            <!-- إحصائيات سريعة -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="elite-card stat-card text-center">
                        <div class="card-body">
                            <h4 class="text-gold mb-1">{{ $products->count() }}</h4>
                            <p class="text-muted mb-0">إجمالي المنتجات</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="elite-card stat-card text-center">
                        <div class="card-body">
                            <h4 class="text-success mb-1">{{ $products->where('status', 'active')->count() }}</h4>
                            <p class="text-muted mb-0">منتجات نشطة</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="elite-card stat-card text-center">
                        <div class="card-body">
                            <h4 class="text-aqua mb-1">{{ $products->sum('views') }}</h4>
                            <p class="text-muted mb-0">إجمالي المشاهدات</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="elite-card stat-card text-center">
                        <div class="card-body">
                            <h4 class="text-warning mb-1">{{ $products->where('discount_percentage', '>', 0)->count() }}</h4>
                            <p class="text-muted mb-0">منتجات مخفضة</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قائمة المنتجات -->
            <div class="elite-card">
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>الصورة</th>
                                        <th>اسم المنتج</th>
                                        <th>التصنيف</th>
                                        <th>السعر</th>
                                        <th>المشاهدات</th>
                                        <th>التخفيض</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            @if($product->images)
                                                @php
                                                    $images = json_decode($product->images);
                                                    $firstImage = $images[0] ?? null;
                                                @endphp
                                                @if($firstImage)
                                                    <img src="{{ asset('storage/' . $firstImage) }}" 
                                                         class="product-thumb" 
                                                         alt="{{ $product->name }}">
                                                @else
                                                    <div class="no-image-thumb">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="no-image-thumb">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        </td>
                                        <td>
                                            @if($product->category)
                                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                                            @else
                                                <span class="badge bg-secondary">بدون تصنيف</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->discount_percentage > 0)
                                                <span class="text-danger fw-bold">{{ number_format($product->price - ($product->price * $product->discount_percentage / 100), 2) }} ر.س</span>
                                                <br>
                                                <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }} ر.س</small>
                                            @else
                                                <span class="fw-bold">{{ number_format($product->price, 2) }} ر.س</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-aqua">{{ $product->views }}</span>
                                        </td>
                                        <td>
                                            @if($product->discount_percentage > 0)
                                                <span class="badge bg-success">{{ $product->discount_percentage }}%</span>
                                            @else
                                                <span class="badge bg-secondary">لا يوجد</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->status === 'active')
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-warning">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('products.show', $product->id) }}" 
                                                   class="btn btn-outline-aqua" 
                                                   title="عرض المنتج">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" 
                                                   class="btn btn-outline-warning"
                                                   title="تعديل المنتج">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="حذف المنتج">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-4x text-muted mb-4"></i>
                            <h4 class="text-gold mb-3">لا توجد منتجات حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإضافة أول منتج لمتجرك</p>
                            <a href="{{ route('merchant.products.create') }}" class="btn btn-gold btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>
                                إضافة أول منتج
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.merchant-avatar {
    position: relative;
    display: inline-block;
}

.merchant-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid var(--gold-primary);
    object-fit: cover;
}

.merchant-nav .nav-link {
    color: var(--text-primary);
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    border: none;
}

.merchant-nav .nav-link:hover,
.merchant-nav .nav-link.active {
    background: var(--gold-primary);
    color: #000 !important;
}

.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.product-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.no-image-thumb {
    width: 50px;
    height: 50px;
    background: var(--dark-surface);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

.table-dark {
    background: var(--dark-card);
    border-radius: 10px;
    overflow: hidden;
}

.table-dark th {
    border-bottom: 1px solid var(--dark-border);
    background: rgba(212, 175, 55, 0.1);
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .merchant-img {
        width: 60px;
        height: 60px;
    }
}
</style>
@endsection
