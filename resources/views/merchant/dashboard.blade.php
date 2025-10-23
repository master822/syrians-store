@extends('layouts.app')

@section('title', 'لوحة تحكم التاجر')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">
                    <i class="fas fa-store me-2"></i>لوحة تحكم التاجر
                </h1>
                <div class="badge bg-primary fs-6">
                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الخطة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-crown text-warning me-2"></i>معلومات الخطة الحالية
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="plan-info">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="plan-icon me-3">
                                        @if(Auth::user()->current_plan === 'free')
                                            <i class="fas fa-user fa-2x text-secondary"></i>
                                        @elseif(Auth::user()->current_plan === 'basic')
                                            <i class="fas fa-star fa-2x text-primary"></i>
                                        @elseif(Auth::user()->current_plan === 'medium')
                                            <i class="fas fa-gem fa-2x text-success"></i>
                                        @else
                                            <i class="fas fa-crown fa-2x text-warning"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-{{ 
                                            Auth::user()->current_plan === 'free' ? 'secondary' : 
                                            (Auth::user()->current_plan === 'basic' ? 'primary' : 
                                            (Auth::user()->current_plan === 'medium' ? 'success' : 'warning')) 
                                        }}">
                                            {{ Auth::user()->getSubscriptionPlanNameAttribute() }}
                                        </h4>
                                        <p class="text-muted mb-0">
                                            @if(Auth::user()->current_plan === 'free')
                                                الخطة المجانية
                                            @else
                                                {{ Auth::user()->current_plan === 'basic' ? 'الخطة الأساسية' : 
                                                   (Auth::user()->current_plan === 'medium' ? 'الخطة المتوسطة' : 'الخطة المميزة') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="plan-days">
                                @php
                                    $daysLeft = 0;
                                    $isTrial = false;
                                    
                                    if (Auth::user()->is_trial_used === false && Auth::user()->created_at->addDays(Auth::user()->trial_days)->isFuture()) {
                                        $daysLeft = now()->diffInDays(Auth::user()->created_at->addDays(Auth::user()->trial_days), false);
                                        $isTrial = true;
                                    } elseif (Auth::user()->subscription_end && Auth::user()->subscription_end->isFuture()) {
                                        $daysLeft = now()->diffInDays(Auth::user()->subscription_end, false);
                                        $isTrial = false;
                                    }
                                @endphp
                                
                                @if($daysLeft > 0)
                                    <div class="alert alert-{{ $isTrial ? 'info' : 'success' }} mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt fa-2x me-3"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">
                                                    @if($isTrial)
                                                        الفترة التجريبية
                                                    @else
                                                        الخطة الحالية
                                                    @endif
                                                </h6>
                                                <p class="mb-0">
                                                    @if($isTrial)
                                                        متبقي <strong>{{ $daysLeft }}</strong> يوم من الفترة التجريبية
                                                    @else
                                                        متبقي <strong>{{ $daysLeft }}</strong> يوم في الخطة الحالية
                                                    @endif
                                                </p>
                                                <small class="text-muted">
                                                    @if($isTrial)
                                                        تنتهي في {{ Auth::user()->created_at->addDays(Auth::user()->trial_days)->format('Y-m-d') }}
                                                    @else
                                                        تنتهي في {{ Auth::user()->subscription_end->format('Y-m-d') }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">الخطة منتهية</h6>
                                                <p class="mb-0">يرجى تجديد الخطة للمتابعة</p>
                                                <a href="{{ route('merchant.subscription.plans') }}" class="btn btn-sm btn-warning mt-2">
                                                    <i class="fas fa-rocket me-1"></i>ترقية الآن
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أزرار الإجراءات السريعة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-bolt text-warning me-2"></i>إجراءات سريعة
                    </h5>
                    <div class="row g-3">
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('merchant.products.create') }}" class="btn btn-primary w-100 h-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                    <span>إضافة منتج جديد</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('merchant.products') }}" class="btn btn-success w-100 h-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-boxes fa-2x mb-2"></i>
                                    <span>إدارة منتجاتي</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('merchant.subscription.plans') }}" class="btn btn-warning w-100 h-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-rocket fa-2x mb-2"></i>
                                    <span>ترقية الخطة</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="{{ route('merchant.discounts') }}" class="btn btn-info w-100 h-100 py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-tag fa-2x mb-2"></i>
                                    <span>إدارة التخفيضات</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإشعارات السريعة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-bell text-warning me-2"></i>الإشعارات الحديثة
                    </h5>
                    <div class="row">
                        <!-- إشعارات الرسائل -->
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-envelope fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">رسائل جديدة</h6>
                                    <p class="mb-0">لديك <strong>{{ $unreadMessagesCount }}</strong> رسالة غير مقروءة</p>
                                    <a href="{{ route('messages.inbox') }}" class="btn btn-sm btn-outline-info mt-2">عرض الرسائل</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- إشعارات التقييمات -->
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-star fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">تقييمات جديدة</h6>
                                    <p class="mb-0">لديك <strong>{{ $newRatingsCount }}</strong> تقييم جديد</p>
                                    <a href="#ratings-section" class="btn btn-sm btn-outline-warning mt-2">عرض التقييمات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">إجمالي المنتجات</h6>
                            <h3 class="mb-0">{{ $stats['total_products'] }}</h3>
                            <small>الحد الأقصى: {{ Auth::user()->product_limit }}</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">المنتجات النشطة</h6>
                            <h3 class="mb-0">{{ $stats['active_products'] }}</h3>
                            <small>منتجات مفعلة</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">إجمالي المشاهدات</h6>
                            <h3 class="mb-0">{{ $stats['total_views'] }}</h3>
                            <small>مشاهدات المنتجات</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-eye fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">متوسط التقييم</h6>
                            <h3 class="mb-0">{{ number_format($stats['average_rating'], 1) }}/5</h3>
                            <small>من {{ $stats['total_ratings'] }} تقييم</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-star fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الرسائل الحديثة -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>آخر الرسائل
                    </h5>
                    <span class="badge bg-light text-primary">{{ $recentMessages->count() }}</span>
                </div>
                <div class="card-body">
                    @if($recentMessages->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentMessages as $message)
                                <div class="list-group-item px-0 {{ !$message->is_read ? 'bg-light' : '' }}">
                                    <div class="d-flex align-items-start">
                                        @if(!$message->is_read)
                                            <span class="badge bg-primary me-2">جديد</span>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                من: {{ $message->sender->name }}
                                                @if($message->product)
                                                    <small class="text-muted"> - {{ $message->product->name }}</small>
                                                @endif
                                            </h6>
                                            <p class="mb-1 text-muted small">{{ Str::limit($message->message, 80) }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $message->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#messageModal{{ $message->id }}">
                                                        <i class="fas fa-eye me-2"></i>عرض الرسالة
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item reply-btn" href="#"
                                                       data-sender-id="{{ $message->sender_id }}"
                                                       data-sender-name="{{ $message->sender->name }}">
                                                        <i class="fas fa-reply me-2"></i>رد
                                                    </a>
                                                </li>
                                                @if(!$message->is_read)
                                                    <li>
                                                        <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check me-2"></i>تم القراءة
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- مودال عرض الرسالة -->
                                <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">رسالة من {{ $message->sender->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($message->product)
                                                    <div class="alert alert-info mb-3">
                                                        <strong>عن المنتج:</strong> 
                                                        <a href="{{ route('products.show', $message->product->id) }}" target="_blank">
                                                            {{ $message->product->name }}
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="message-content bg-light p-3 rounded">
                                                    <p class="mb-0">{{ $message->message }}</p>
                                                </div>
                                                <div class="mt-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $message->created_at->format('Y-m-d H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                <button type="button" class="btn btn-primary reply-btn"
                                                        data-sender-id="{{ $message->sender_id }}"
                                                        data-sender-name="{{ $message->sender->name }}"
                                                        data-bs-dismiss="modal">
                                                    <i class="fas fa-reply me-1"></i>الرد على الرسالة
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('messages.inbox') }}" class="btn btn-outline-primary">
                                <i class="fas fa-inbox me-2"></i>عرض جميع الرسائل
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-envelope-open fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">لا توجد رسائل جديدة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- التقييمات الحديثة -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="ratings-section">
                        <i class="fas fa-star me-2"></i>آخر التقييمات
                    </h5>
                    <span class="badge bg-light text-warning">{{ $recentRatings->count() }}</span>
                </div>
                <div class="card-body">
                    @if($recentRatings->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentRatings as $rating)
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0">{{ $rating->user->name }}</h6>
                                                <div class="rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $rating->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="text-muted ms-1">{{ $rating->rating }}/5</span>
                                                </div>
                                            </div>
                                            @if($rating->comment)
                                                <p class="mb-2 text-muted">{{ $rating->comment }}</p>
                                            @endif
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $rating->created_at->diffForHumans() }}
                                            </small>
                                            @if($rating->is_flagged)
                                                <div class="mt-2">
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-flag me-1"></i>تم الإبلاغ
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="#all-ratings" class="btn btn-outline-warning" onclick="showAllRatings()">
                                <i class="fas fa-list me-2"></i>عرض جميع التقييمات
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-star fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">لا توجد تقييمات جديدة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- جميع التقييمات (مخفي افتراضياً) -->
    <div class="row mb-4 d-none" id="allRatingsSection">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>جميع التقييمات
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($allRatings as $rating)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title">{{ $rating->user->name }}</h6>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $rating->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if($rating->comment)
                                            <p class="card-text text-muted">{{ $rating->comment }}</p>
                                        @else
                                            <p class="card-text text-muted">لا يوجد تعليق</p>
                                        @endif
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $rating->created_at->format('Y-m-d H:i') }}
                                        </small>
                                        @if($rating->is_flagged)
                                            <div class="mt-2">
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-flag me-1"></i>مفعل - {{ $rating->moderation_reason }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مودال الرد على الرسالة -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إرسال رد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="replyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="receiver_id" id="receiverId">
                    <div class="mb-3">
                        <label class="form-label">إلى: <span id="receiverName" class="fw-bold"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">الرسالة</label>
                        <textarea class="form-control" id="replyMessage" name="message" rows="5" 
                                  placeholder="اكتب رسالتك هنا..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال الرد</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #eee;
}

.list-group-item:last-child {
    border-bottom: none;
}

.rating-stars {
    direction: ltr;
    unicode-bidi: bidi-override;
}

.bg-light {
    background-color: #e3f2fd !important;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.plan-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
}
</style>

<script>
function showAllRatings() {
    document.getElementById('allRatingsSection').classList.remove('d-none');
    document.getElementById('allRatingsSection').scrollIntoView({ behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    // إعداد الرد على الرسائل
    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const senderId = this.getAttribute('data-sender-id');
            const senderName = this.getAttribute('data-sender-name');
            
            document.getElementById('receiverId').value = senderId;
            document.getElementById('receiverName').textContent = senderName;
            document.getElementById('replyForm').action = "{{ route('messages.contact', 0) }}".replace('0', '0');
            
            const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        });
    });

    // إرسال نموذج الرد
    document.getElementById('replyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const receiverId = document.getElementById('receiverId').value;
        
        fetch("{{ route('messages.contact', 0) }}".replace('0', '0'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('replyModal')).hide();
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // تحديث الإشعارات كل 30 ثانية
    setInterval(() => {
        fetch('{{ route("merchant.dashboard") }}')
            .then(response => response.text())
            .then(html => {
                // يمكن إضافة تحديث ديناميكي للإشعارات هنا
                console.log('Dashboard updated');
            });
    }, 30000);
});
</script>
@endsection
