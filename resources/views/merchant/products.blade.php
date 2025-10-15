@extends('layouts.app')

@section('title', 'منتجاتي - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-gold">
                    <i class="fas fa-boxes me-2"></i>منتجاتي
                </h1>
                <a href="{{ route('products.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus-circle me-2"></i>إضافة منتج جديد
                </a>
            </div>
            <p class="text-light">إدارة منتجات متجرك</p>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المنتجات</h6>
                            <h4 class="text-aqua mb-0">{{ $products->count() }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-boxes fa-2x text-aqua"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات النشطة</h6>
                            <h4 class="text-success mb-0">{{ $products->where('status', 'active')->count() }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">إجمالي المشاهدات</h6>
                            <h4 class="text-warning mb-0">{{ $products->sum('views') }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-eye fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="elite-card stats-card bg-dark-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted mb-2">المنتجات المخفضة</h6>
                            <h4 class="text-danger mb-0">{{ $products->where('discount_percentage', '>', 0)->count() }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-tag fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة المنتجات -->
    <div class="row">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-list me-2"></i>قائمة المنتجات
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">الصورة</th>
                                        <th class="border-0">اسم المنتج</th>
                                        <th class="border-0">السعر</th>
                                        <th class="border-0">التصنيف</th>
                                        <th class="border-0">المشاهدات</th>
                                        <th class="border-0">الحالة</th>
                                        <th class="border-0">التخفيض</th>
                                        <th class="border-0">الإجراءات</th>
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
                                                         alt="{{ $product->name }}" 
                                                         class="rounded"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-light">{{ $product->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="text-aqua">{{ number_format($product->price) }} ل.س</span>
                                            @if($product->discount_percentage > 0)
                                                <br>
                                                <small class="text-danger">
                                                    بعد الخصم: {{ number_format($product->price - ($product->price * $product->discount_percentage / 100)) }} ل.س
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $product->category->name ?? 'غير محدد' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-warning">{{ $product->views }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->discount_percentage > 0)
                                                <span class="badge bg-danger">{{ $product->discount_percentage }}%</span>
                                            @else
                                                <span class="badge bg-secondary">لا يوجد</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('products.show', $product->id) }}" 
                                                   class="btn btn-primary" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" 
                                                   class="btn btn-warning" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($product->discount_percentage == 0)
                                                    <a href="{{ route('merchant.discounts.create') }}?product={{ $product->id }}" 
                                                       class="btn btn-success" title="إضافة تخفيض">
                                                        <i class="fas fa-tag"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('merchant.discounts.edit', $product->id) }}" 
                                                       class="btn btn-info" title="تعديل التخفيض">
                                                        <i class="fas fa-percentage"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('products.destroy', $product->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')"
                                                            title="حذف">
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
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">لا توجد منتجات حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإضافة أول منتج لمتجرك</p>
                            <a href="{{ route('products.create') }}" class="btn btn-gold btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>إضافة أول منتج
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    transition: transform 0.3s ease;
    border: 1px solid var(--dark-border);
}

.stats-card:hover {
    transform: translateY(-5px);
}

.table-dark {
    background: var(--dark-card);
    border-color: var(--dark-border);
}

.table-dark th {
    border-color: var(--dark-border);
    color: var(--gold-primary);
    font-weight: 600;
    padding: 1rem 0.75rem;
}

.table-dark td {
    border-color: var(--dark-border);
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.btn-group .btn {
    border-radius: 5px;
    margin: 1px;
    padding: 0.25rem 0.5rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}
</style>
@endsection
