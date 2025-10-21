@extends('layouts.app')

@section('title', 'منتجاتي المستعملة - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-gold">
                    <i class="fas fa-boxes me-2"></i>منتجاتي المستعملة
                </h1>
                <a href="{{ route('products.create') }}" class="btn btn-gold">
                    <i class="fas fa-plus-circle me-2"></i>إضافة منتج مستعمل
                </a>
            </div>
            <p class="text-light">إدارة منتجاتك المستعملة المعروضة للبيع</p>
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
                            <h6 class="text-muted mb-2">المنتجات المتبقية</h6>
                            <h4 class="text-info mb-0">{{ Auth::user()->product_limit - $products->count() }}</h4>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-layer-group fa-2x text-info"></i>
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
                        <i class="fas fa-list me-2"></i>قائمة منتجاتي المستعملة
                    </h5>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>الصورة</th>
                                        <th>اسم المنتج</th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                        <th>التصنيف</th>
                                        <th>المشاهدات</th>
                                        <th>تاريخ الإضافة</th>
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
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $product->condition == 'جديدة' ? 'success' : ($product->condition == 'جيدة جداً' ? 'info' : ($product->condition == 'جيدة' ? 'warning' : 'secondary')) }}">
                                                {{ $product->condition }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $product->category->name ?? 'غير محدد' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-warning">{{ $product->views }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->created_at->format('Y-m-d') }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.show', $product->id) }}" 
                                                   class="btn btn-sm btn-primary" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" 
                                                   class="btn btn-sm btn-warning" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
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

                        <!-- رسالة المساحة المتبقية -->
                        @if($products->count() >= Auth::user()->product_limit)
                        <div class="alert alert-warning mt-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>تنبيه:</strong> لقد وصلت إلى الحد الأقصى للمنتجات المسموح بها ({{ Auth::user()->product_limit }} منتج). 
                            لا يمكنك إضافة المزيد من المنتجات.
                        </div>
                        @else
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>معلومات:</strong> يمكنك إضافة {{ Auth::user()->product_limit - $products->count() }} منتج إضافي.
                        </div>
                        @endif

                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">لا توجد منتجات مستعملة حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإضافة أول منتج مستعمل للبيع</p>
                            <a href="{{ route('products.create') }}" class="btn btn-gold btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>إضافة أول منتج مستعمل
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- نصائح للبيع -->
    @if($products->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-lightbulb me-2"></i>نصائح لزيادة المبيعات
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-camera text-aqua fa-2x me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-light mb-1">صور واضحة</h6>
                                    <p class="text-muted mb-0">استخدم صور عالية الجودة من زوايا متعددة</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt text-warning fa-2x me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-light mb-1">وصف دقيق</h6>
                                    <p class="text-muted mb-0">اذكر جميع العيوب والمميزات بصراحة</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-tag text-success fa-2x me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-light mb-1">سعر معقول</h6>
                                    <p class="text-muted mb-0">ضع سعر مناسب لحالة المنتج وسعره الأصلي</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
}

.table-dark td {
    border-color: var(--dark-border);
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 5px;
    margin: 2px;
}

.alert {
    border: 1px solid;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}
</style>
@endsection
