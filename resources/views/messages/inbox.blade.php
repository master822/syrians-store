@extends('layouts.app')

@section('title', 'صندوق الوارد - الرسائل')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-primary mb-4">
                <i class="fas fa-inbox me-2"></i>صندوق الوارد
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($messages->count() > 0)
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">الرسائل الواردة</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <div class="list-group-item {{ !$message->is_read ? 'bg-light' : '' }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center">
                                                @if($message->sender->avatar)
                                                    <img src="{{ asset('storage/' . $message->sender->avatar) }}" 
                                                         alt="{{ $message->sender->name }}" 
                                                         class="rounded-circle me-3"
                                                         style="width: 45px; height: 45px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 45px; height: 45px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 {{ !$message->is_read ? 'fw-bold' : '' }}">
                                                        {{ $message->sender->name }}
                                                        @if($message->sender->user_type === 'merchant')
                                                            <small class="text-muted">(تاجر)</small>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-1 text-muted">{{ Str::limit($message->message, 100) }}</p>
                                                    @if($message->product)
                                                        <small class="text-info">
                                                            <i class="fas fa-shopping-bag me-1"></i>
                                                            عن منتج: {{ $message->product->name }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <small class="text-muted d-block">
                                                {{ $message->created_at->diffForHumans() }}
                                            </small>
                                            <div class="mt-2">
                                                <a href="{{ route('messages.conversation', $message->sender_id) }}" 
                                                   class="btn btn-primary btn-sm me-2">
                                                    <i class="fas fa-reply me-1"></i>رد
                                                </a>
                                                @if(!$message->is_read)
                                                    <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fas fa-check me-1"></i>تحديد كمقروء
                                                        </button>
                                                    </form>
                                                @endif
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
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد رسائل</h4>
                    <p class="text-muted">لم تتلق أي رسائل بعد</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
