@extends('layouts.app')

@section('title', 'لوحة تحكم المسؤول')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center text-primary">لوحة تحكم المسؤول</h1>
            <p class="text-center text-muted">مرحباً بك في لوحة التحكم الإدارية</p>
        </div>
    </div>

    <div class="row">
        <!-- بطاقة إحصائيات المستخدمين -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-primary mb-3"></i>
                    <h3>{{ \App\Models\User::where('user_type', 'user')->count() }}</h3>
                    <p class="card-text">المستخدمين العاديين</p>
                </div>
            </div>
        </div>

        <!-- بطاقة إحصائيات التجار -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-store fa-2x text-success mb-3"></i>
                    <h3>{{ \App\Models\User::where('user_type', 'merchant')->count() }}</h3>
                    <p class="card-text">التجار</p>
                </div>
            </div>
        </div>

        <!-- بطاقة إحصائيات المنتجات -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-box fa-2x text-warning mb-3"></i>
                    <h3>{{ \App\Models\Product::count() }}</h3>
                    <p class="card-text">المنتجات</p>
                </div>
            </div>
        </div>

        <!-- بطاقة إحصائيات التصنيفات -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tags fa-2x text-info mb-3"></i>
                    <h3>{{ \App\Models\Category::count() }}</h3>
                    <p class="card-text">التصنيفات</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">روابط سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-users me-2"></i>إدارة المستخدمين
                        </a>
                        <a href="{{ route('admin.merchants') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-store me-2"></i>إدارة التجار
                        </a>
                        <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-box me-2"></i>إدارة المنتجات
                        </a>
                       <!--    
                        <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tags me-2"></i>إدارة التصنيفات
                        </a>
                        
                        -->
                        <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-cog me-2"></i>إعدادات الموقع
                        </a>
                        <a href="{{ route('admin.profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user me-2"></i>الملف الشخصي
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">آخر المستخدمين</h5>
                </div>
                <div class="card-body">
                    @php
                        $recentUsers = \App\Models\User::latest()->take(5)->get();
                    @endphp
                    @foreach($recentUsers as $user)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <span class="badge bg-{{ $user->user_type === 'admin' ? 'danger' : ($user->user_type === 'merchant' ? 'success' : 'primary') }}">
                                {{ $user->user_type === 'admin' ? 'مسؤول' : ($user->user_type === 'merchant' ? 'تاجر' : 'مستخدم') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.list-group-item {
    border: none;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}
</style>
@endsection
