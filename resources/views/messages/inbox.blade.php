@extends('layouts.app')

@section('title', 'الرسائل الواردة')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-primary mb-4">
                <i class="fas fa-inbox me-2"></i>الرسائل الواردة
            </h1>
        </div>
    </div>

    @if($messages->count() > 0)
        <div class="row">
            @foreach($messages as $message)
                <div class="col-12 mb-3">
                    <div class="modern-card p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $message->sender->getAvatarUrlAttribute() }}" 
                                         alt="{{ $message->sender->name }}" 
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <h5 class="text-primary mb-1">{{ $message->sender->name }}</h5>
                                        <p class="text-muted mb-1">{{ $message->message }}</p>
                                        @if($message->product)
                                            <small class="text-info">
                                                <i class="fas fa-box me-1"></i>
                                                عن المنتج: {{ $message->product->name }}
                                            </small>
                                        @endif
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $message->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if(!$message->is_read)
                                    <span class="badge bg-primary mb-2">جديد</span>
                                @endif
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#replyModal{{ $message->id }}">
                                        <i class="fas fa-reply me-1"></i>رد
                                    </button>
                                    <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-check me-1"></i>تم القراءة
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- نموذج الرد -->
                    <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">رد على {{ $message->sender->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('messages.contact', $message->product ? $message->product->id : 0) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $message->sender->id }}">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">الرسالة</label>
                                            <textarea name="message" class="form-control" rows="4" 
                                                      placeholder="اكتب ردك هنا..." required></textarea>
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
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card text-center py-5">
                    <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-primary">لا توجد رسائل</h4>
                    <p class="text-muted">ليس لديك أي رسائل واردة حالياً</p>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: none;
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.btn-group .btn {
    margin-left: 5px;
}
</style>
@endsection
