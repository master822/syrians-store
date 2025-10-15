@extends('layouts.app')

@section('title', 'صندوق الرسائل')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="modern-card p-4">
                <h4 class="text-center mb-4 text-primary">صندوق الرسائل</h4>
                
                @if($messages->count() > 0)
                    <div class="messages-list">
                        @foreach($messages as $message)
                        <div class="message-item border rounded p-3 mb-3 {{ $message->is_read ? '' : 'bg-light' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-dark">
                                        من: {{ $message->sender->name }}
                                        @if($message->product)
                                        - بخصوص: {{ $message->product->name }}
                                        @endif
                                    </h6>
                                    <p class="mb-2 text-dark">{{ $message->message }}</p>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="ms-3">
                                    @if(!$message->is_read)
                                    <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">تم القراءة</button>
                                    </form>
                                    @else
                                    <span class="badge bg-secondary">مقروء</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark">لا توجد رسائل</h5>
                        <p class="text-muted">لم تتلق أي رسائل بعد</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
