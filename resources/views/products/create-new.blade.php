@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">إضافة منتج جديد</h4>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="is_used" value="0">
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">وصف المنتج *</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">السعر (ريال سعودي) *</label>
                        <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">التصنيف *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">اختر التصنيف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">صور المنتج (يمكن رفع أكثر من صورة)</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">يمكنك رفع أكثر من صورة للمنتج</small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
