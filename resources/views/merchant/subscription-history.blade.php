@extends('layouts.app')

@section('title', 'تاريخ الاشتراكات - Merchanta')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-history me-2"></i>تاريخ الاشتراكات</h2>
                <a href="{{ route('merchant.subscription.plans') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>اشتراك جديد
                </a>
            </div>

            <!-- حالة الاشتراك الحالي -->
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">الاشتراك الحالي</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>الخطة:</strong> 
                                        <span class="badge bg-{{ $user->current_plan == 'premium' ? 'warning' : ($user->current_plan == 'medium' ? 'info' : 'success') }} fs-6">
                                            {{ $user->getSubscriptionPlanNameAttribute() }}
                                        </span>
                                    </p>
                                    <p><strong>عدد المنتجات المسموح:</strong> {{ $user->product_limit }}</p>
                                </div>
                                <div class="col-md-6">
                                    @if($user->current_plan != 'free')
                                        <p><strong>ينتهي في:</strong> 
                                            <span class="{{ $user->subscription_end->isPast() ? 'text-danger' : 'text-success' }}">
                                                {{ $user->subscription_end->format('Y-m-d') }}
                                            </span>
                                        </p>
                                        <p><strong>الأيام المتبقية:</strong> 
                                            <span class="badge bg-{{ now()->diffInDays($user->subscription_end, false) > 7 ? 'success' : 'warning' }}">
                                                {{ now()->diffInDays($user->subscription_end, false) }} يوم
                                            </span>
                                        </p>
                                    @else
                                        <p><strong>الحالة:</strong> 
                                            @if($isInTrial)
                                                <span class="badge bg-info">فترة تجريبية</span>
                                                <small class="text-muted d-block">متبقي {{ $daysLeft }} يوم</small>
                                            @else
                                                <span class="badge bg-secondary">مجاني</span>
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            @if($user->current_plan != 'free' && $user->subscription_end->isFuture())
                            <div class="mt-3">
                                <button class="btn btn-outline-danger btn-sm" onclick="confirmCancel()">
                                    <i class="fas fa-times me-2"></i>إلغاء الاشتراك
                                </button>
                                <small class="text-muted d-block mt-1">سيتم إلغاء التجديد التلقائي</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- قائمة الاشتراكات السابقة -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">سجل الاشتراكات</h5>
                </div>
                <div class="card-body">
                    @if($subscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الخطة</th>
                                        <th>المبلغ</th>
                                        <th>طريقة الدفع</th>
                                        <th>الحالة</th>
                                        <th>تاريخ البدء</th>
                                        <th>تاريخ الانتهاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge bg-{{ $subscription->plan_type == 'premium' ? 'warning' : ($subscription->plan_type == 'medium' ? 'info' : 'success') }}">
                                                {{ $subscription->getPlanNameAttribute() }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($subscription->amount, 2) }} TL</td>
                                        <td>
                                            @if($subscription->payment_method == 'stripe')
                                                <i class="fab fa-cc-stripe text-primary me-1"></i> Stripe
                                            @elseif($subscription->payment_method == 'paypal')
                                                <i class="fab fa-paypal text-primary me-1"></i> PayPal
                                            @else
                                                <i class="fas fa-credit-card text-primary me-1"></i> {{ $subscription->payment_method }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($subscription->status == 'completed')
                                                <span class="badge bg-success">مكتمل</span>
                                            @elseif($subscription->status == 'pending')
                                                <span class="badge bg-warning">قيد الانتظار</span>
                                            @else
                                                <span class="badge bg-danger">{{ $subscription->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $subscription->starts_at->format('Y-m-d') }}</td>
                                        <td>{{ $subscription->ends_at ? $subscription->ends_at->format('Y-m-d') : '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="tooltip" 
                                                    title="تفاصيل الدفع"
                                                    onclick="showPaymentDetails({{ $subscription }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- الترقيم -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $subscriptions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد اشتراكات سابقة</h5>
                            <p class="text-muted">لم تقم بأي عمليات اشتراك حتى الآن</p>
                            <a href="{{ route('merchant.subscription.plans') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>اشتراك جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تفاصيل الدفع -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paymentDetailsContent">
                <!-- سيتم ملؤه بالجافاسكريبت -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmCancel() {
    if (confirm('هل أنت متأكد من إلغاء الاشتراك؟ سيتم إيقاف التجديد التلقائي وسينتهي اشتراكك في تاريخ انتهاء الفترة الحالية.')) {
        window.location.href = "{{ route('subscription.cancel') }}";
    }
}

function showPaymentDetails(subscription) {
    const content = `
        <div class="row">
            <div class="col-6">
                <strong>رقم العملية:</strong>
            </div>
            <div class="col-6">
                ${subscription.payment_id}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <strong>طريقة الدفع:</strong>
            </div>
            <div class="col-6">
                ${subscription.payment_method}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <strong>المبلغ:</strong>
            </div>
            <div class="col-6">
                ${subscription.amount} TL
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <strong>الحالة:</strong>
            </div>
            <div class="col-6">
                <span class="badge bg-${subscription.status === 'completed' ? 'success' : 'warning'}">
                    ${subscription.status === 'completed' ? 'مكتمل' : 'قيد الانتظار'}
                </span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <strong>ملاحظات:</strong>
            </div>
            <div class="col-6">
                ${subscription.notes || 'لا توجد ملاحظات'}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <strong>تاريخ الإنشاء:</strong>
            </div>
            <div class="col-6">
                ${new Date(subscription.created_at).toLocaleDateString('ar-EG')}
            </div>
        </div>
    `;
    
    document.getElementById('paymentDetailsContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('paymentDetailsModal')).show();
}

// تفعيل أدوات التلميح
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5em 0.75em;
}

.card {
    border-radius: 12px;
}

.btn {
    border-radius: 8px;
}
</style>
@endpush
