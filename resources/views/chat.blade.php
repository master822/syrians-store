@extends('layouts.app')

@section('title', 'المحادثات - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-gold mb-4">
                <i class="fas fa-comments me-2"></i>المحادثات
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- قائمة المحادثات -->
        <div class="col-lg-4 mb-4">
            <div class="elite-card h-100">
                <div class="card-header bg-dark-card py-3">
                    <h5 class="text-gold mb-0">
                        <i class="fas fa-list me-2"></i>المحادثات النشطة
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- محادثة مثال -->
                        <a href="#" class="list-group-item list-group-item-action bg-transparent border-secondary chat-item active">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=أحمد+التاجر&background=6366f1&color=fff" 
                                     alt="أحمد التاجر" 
                                     class="rounded-circle me-3"
                                     style="width: 45px; height: 45px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-light mb-1">أحمد التاجر</h6>
                                        <small class="text-muted">10:30 ص</small>
                                    </div>
                                    <p class="text-muted mb-0 small">مرحباً، هل المنتج متوفر؟</p>
                                </div>
                                <span class="badge bg-aqua rounded-pill">2</span>
                            </div>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action bg-transparent border-secondary chat-item">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=محمد+المحلاتي&background=8b5cf6&color=fff" 
                                     alt="محمد المحلاتي" 
                                     class="rounded-circle me-3"
                                     style="width: 45px; height: 45px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-light mb-1">محمد المحلاتي</h6>
                                        <small class="text-muted">أمس</small>
                                    </div>
                                    <p class="text-muted mb-0 small">شكراً لك على الشراء</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action bg-transparent border-secondary chat-item">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=سارة+العميل&background=20c997&color=fff" 
                                     alt="سارة العميل" 
                                     class="rounded-circle me-3"
                                     style="width: 45px; height: 45px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-light mb-1">سارة العميل</h6>
                                        <small class="text-muted">2 يوم</small>
                                    </div>
                                    <p class="text-muted mb-0 small">متى سيصل الطلب؟</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- نافذة المحادثة -->
        <div class="col-lg-8 mb-4">
            <div class="elite-card h-100 d-flex flex-column">
                <div class="card-header bg-dark-card d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=أحمد+التاجر&background=6366f1&color=fff" 
                             alt="أحمد التاجر" 
                             class="rounded-circle me-3"
                             style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h6 class="text-light mb-0">أحمد التاجر</h6>
                            <small class="text-muted">متصل الآن</small>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-aqua btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>عرض المتجر</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-ban me-2"></i>حظر</a></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>حذف المحادثة</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body chat-messages flex-grow-1" style="overflow-y: auto;">
                    <!-- الرسائل -->
                    <div class="message received mb-3">
                        <div class="message-content bg-dark-surface rounded p-3">
                            <p class="text-light mb-1">مرحباً، هل المنتج متوفر؟</p>
                            <small class="text-muted">10:30 ص</small>
                        </div>
                    </div>

                    <div class="message sent mb-3 text-end">
                        <div class="message-content bg-aqua rounded p-3 d-inline-block">
                            <p class="text-dark mb-1">نعم، المنتج متوفر وجاهز للشحن</p>
                            <small class="text-dark">10:31 ص</small>
                        </div>
                    </div>

                    <div class="message received mb-3">
                        <div class="message-content bg-dark-surface rounded p-3">
                            <p class="text-light mb-1">ممتاز! هل يمكنني الحصول على خصم إذا اشتريت كميتين؟</p>
                            <small class="text-muted">10:32 ص</small>
                        </div>
                    </div>

                    <div class="message sent mb-3 text-end">
                        <div class="message-content bg-aqua rounded p-3 d-inline-block">
                            <p class="text-dark mb-1">بالتأكيد، يمكنني تقديم خصم 10% للكميات</p>
                            <small class="text-dark">10:33 ص</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-transparent border-secondary">
                    <form class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <input type="text" class="form-control dark-input" 
                                   placeholder="اكتب رسالتك هنا..." 
                                   style="border-radius: 25px;">
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-aqua rounded-circle me-2" style="width: 40px; height: 40px;">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <button type="button" class="btn btn-outline-aqua rounded-circle me-2" style="width: 40px; height: 40px;">
                                <i class="fas fa-image"></i>
                            </button>
                            <button type="submit" class="btn btn-gold rounded-circle" style="width: 40px; height: 40px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-item {
    transition: all 0.3s ease;
    border: none !important;
    padding: 1rem;
}

.chat-item:hover, .chat-item.active {
    background: var(--dark-surface) !important;
}

.chat-messages {
    scrollbar-width: thin;
    scrollbar-color: var(--aqua-primary) var(--dark-surface);
    max-height: 400px;
}

.message-content {
    max-width: 70%;
    word-wrap: break-word;
}

.message.sent .message-content {
    background: linear-gradient(135deg, var(--aqua-primary), var(--aqua-secondary)) !important;
}

.dark-input {
    background: var(--dark-surface);
    border: 1px solid var(--dark-border);
    color: var(--text-primary);
}

.dark-input:focus {
    background: var(--dark-surface);
    border-color: var(--gold-primary);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.btn-group .btn {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تمرير لأسفل تلقائي في نافذة المحادثة
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // تفعيل المحادثات في القائمة
    const chatItems = document.querySelectorAll('.chat-item');
    chatItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            chatItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endsection
