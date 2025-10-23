@extends('layouts.app')

@section('title', 'الرسائل المرسلة')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-paper-plane me-2"></i>الرسائل المرسلة
                </h1>
                <div class="btn-group">
                    <a href="{{ route('messages.inbox') }}" class="btn btn-outline-primary">
                        <i class="fas fa-inbox me-2"></i>الوارد
                    </a>
                    <a href="{{ route('messages.sent') }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>المرسل
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($messages->count() > 0)
                <div class="card">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h6 class="mb-1">
                                                        إلى: {{ $message->receiver->name }}
                                                        @if($message->product)
                                                            <small class="text-muted"> - عن: {{ $message->product->name }}</small>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-1 text-muted">{{ Str::limit($message->message, 100) }}</p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $message->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#messageModal{{ $message->id }}">
                                                    <i class="fas fa-eye me-1"></i>عرض
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- مودال عرض الرسالة -->
                                <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">رسالة إلى {{ $message->receiver->name }}</h5>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد رسائل مرسلة</h4>
                    <p class="text-muted">لم تقم بإرسال أي رسائل بعد</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.list-group-item {
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa !important;
}
</style>
@endsection
