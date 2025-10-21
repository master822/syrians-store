@extends('layouts.app')

@section('title', 'إدارة المستخدمين - لوحة تحكم المسؤول')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-gold">
                    <i class="fas fa-users me-2"></i>إدارة المستخدمين
                </h1>
                <div class="text-light">
                    <span class="me-3">إجمالي المستخدمين: {{ $users->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-user fa-2x text-info mb-2"></i>
                <h5 class="text-light mb-1">{{ $users->where('user_type', 'user')->count() }}</h5>
                <small class="text-muted">مستخدمين عاديين</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-store fa-2x text-warning mb-2"></i>
                <h5 class="text-light mb-1">{{ $users->where('user_type', 'merchant')->count() }}</h5>
                <small class="text-muted">تاجر</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-crown fa-2x text-danger mb-2"></i>
                <h5 class="text-light mb-1">{{ $users->where('user_type', 'admin')->count() }}</h5>
                <small class="text-muted">مسؤول</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="elite-card bg-dark-card text-center p-3">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h5 class="text-light mb-1">{{ $users->where('is_active', true)->count() }}</h5>
                <small class="text-muted">نشطين</small>
            </div>
        </div>
    </div>

    <!-- جدول المستخدمين -->
    <div class="row">
        <div class="col-12">
            <div class="elite-card">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-list me-2"></i>قائمة جميع المستخدمين
                    </h5>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>المستخدم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>نوع الحساب</th>
                                        <th>الحالة</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>عدد المنتجات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->avatar_url }}" 
                                                     alt="{{ $user->name }}" 
                                                     class="rounded-circle me-3"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <strong class="text-light">{{ $user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $user->phone ?? 'لا يوجد' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-light">{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            @if($user->user_type == 'admin')
                                                <span class="badge bg-danger">مسؤول</span>
                                            @elseif($user->user_type == 'merchant')
                                                <span class="badge bg-warning">تاجر</span>
                                            @else
                                                <span class="badge bg-info">مستخدم</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                                {{ $user->is_active ? 'نشط' : 'معطل' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $user->created_at->format('Y-m-d') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-aqua">{{ $user->products_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.user.view', $user->id) }}" 
                                                   class="btn btn-sm btn-primary" title="عرض التفاصيل">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($user->user_type == 'merchant')
                                                    <a href="{{ route('admin.merchant.store', $user->id) }}" 
                                                       class="btn btn-sm btn-warning" title="عرض المتجر">
                                                        <i class="fas fa-store"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.user.toggle-status', $user->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                            title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                                        <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.user.delete', $user->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم وجميع منتجاته؟')"
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

                        <!-- الترقيم -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">لا يوجد مستخدمين</h4>
                            <p class="text-muted">لم يتم تسجيل أي مستخدمين حتى الآن</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
