@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <div class="card-header bg-primary text-white text-center py-3 mb-4">
                    <h3 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة منتج جديد
                    </h3>
                </div>
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="is_used" value="0">
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control form-control-lg" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">وصف المنتج *</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">السعر (ر.س) *</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">التصنيف *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">اختر التصنيف</option>
                                <option value="1">👕 ملابس</option>
                                <option value="2">📱 إلكترونيات</option>
                                <option value="3">🏠 أدوات منزلية</option>
                                <option value="4">🛒 بقالة</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-dark fw-bold">صور المنتج</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                    
                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-save me-2"></i>إضافة المنتج
                        </button>
                        <a href="{{ route('merchant.products') }}" class="btn btn-outline-secondary py-3">
                            <i class="fas fa-arrow-right me-2"></i>العودة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}
</style>
@endsection
