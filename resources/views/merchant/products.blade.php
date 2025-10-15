@extends('layouts.app')

@section('title', 'منتجاتي - لوحة المتجر')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="modern-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-primary mb-0">منتجاتي</h4>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                    </a>
                </div>

                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-dark">الصورة</th>
                                    <th class="text-dark">اسم المنتج</th>
                                    <th class="text-dark">السعر</th>
                                    <th class="text-dark">التصنيف</th>
                                    <th class="text-dark">الحالة</th>
                                    <th class="text-dark">المشاهدات</th>
                                    <th class="text-dark">الإجراءات</th>
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
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px; border-radius: 8px;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 8px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-dark">{{ $product->name }}</td>
                                    <td class="text-dark">{{ number_format($product->price, 2) }} ر.س</td>
                                    <td class="text-dark">{{ $product->category->name ?? 'غير محدد' }}</td>
                                    <td>
                                        @if($product->status === 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-secondary">غير نشط</span>
                                        @endif
                                    </td>
                                    <td class="text-dark">{{ $product->views }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.show', $product->id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="عرض المنتج">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="تعديل المنتج">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف المنتج">
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
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark">لا توجد منتجات</h5>
                        <p class="text-muted mb-4">لم تقم بإضافة أي منتجات بعد</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>إضافة أول منتج
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
