@extends('layouts.app')

@section('title', 'صندوق الوارد - المراسلات')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-inbox me-2"></i>صندوق الوارد
                </h1>
                <div class="btn-group">
                    <a href="{{ route('messages.inbox') }}" class="btn btn-primary">
                        <i class="fas fa-inbox me-2"></i>الوارد
                    </a>
                    <a href="{{ route('messages.sent') }}" class="btn btn-outline-primary">
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
                                <div class="list-group-item {{ !$message->is_read ? 'bg-light' : '' }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center">
                                                @if(!$message->is_read)
                                                    <span class="badge bg-primary me-3">جديد</span>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">
                                                        من: {{ $message->sender->name }}
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
                                                <a href="#" class="btn btn-sm btn-outline-success reply-btn"
                                                   data-sender-id="{{ $message->sender_id }}"
                                                   data-sender-name="{{ $message->sender->name }}">
                                                    <i class="fas fa-reply me-1"></i>رد
                                                </a>
                                                @if(!$message->is_read)
                                                    <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-check me-1"></i>تم القراءة
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
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
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">صندوق الوارد فارغ</h4>
                    <p class="text-muted">لا توجد رسائل جديدة</p>
                </div>
            @endif
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
.list-group-item {
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa !important;
}

.bg-light {
    background-color: #e3f2fd !important;
}
</style>

<script>
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('replyModal')).hide();
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection
