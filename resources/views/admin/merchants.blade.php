@extends('layouts.app')

@section('title', 'إدارة التجار - المسؤول')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-primary">إدارة التجار</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم التاجر</th>
                            <th>اسم المتجر</th>
                            <th>البريد الإلكتروني</th>
                            <th>عدد المنتجات</th>
                            <th>الخطة</th>
                            <th>الحالة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($merchants as $merchant)
                        @php
                            $productCount = \App\Models\Product::where('user_id', $merchant->id)->count();
                        @endphp
                        <tr>
                            <td>{{ $merchant->id }}</td>
                            <td>{{ $merchant->name }}</td>
                            <td>{{ $merchant->store_name }}</td>
                            <td>{{ $merchant->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $productCount }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $merchant->current_plan === 'premium' ? 'success' : ($merchant->current_plan === 'medium' ? 'warning' : 'secondary') }}">
                                    {{ $merchant->current_plan === 'premium' ? 'مميزة' : ($merchant->current_plan === 'medium' ? 'متوسطة' : ($merchant->current_plan === 'basic' ? 'أساسية' : 'مجانية')) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $merchant->is_active ? 'success' : 'danger' }}">
                                    {{ $merchant->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </td>
                            <td>{{ $merchant->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <!--
                                    <a href="{{ route('admin.merchant.store', $merchant->id) }}" class="btn btn-outline-info">
                                        <i class="fas fa-store"></i>
                                    </a>
                                    -->
                                    <form action="{{ route('admin.user.toggle-status', $merchant->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-{{ $merchant->is_active ? 'warning' : 'success' }}">
                                            <i class="fas fa-{{ $merchant->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.user.delete', $merchant->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('هل أنت متأكد من حذف هذا التاجر؟')">
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

            {{ $merchants->links() }}
        </div>
    </div>
</div>
@endsection
