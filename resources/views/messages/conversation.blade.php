@extends('layouts.app')

@section('title', 'المحادثة - ' . $otherUser->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('messages.inbox') }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-right"></i>
                </a>
                <div class="d-flex align-items-center">
                    @if($otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}" 
                             alt="{{ $otherUser->name }}" 
                             class="rounded-circle me-3"
                             style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="mb-0">{{ $otherUser->name }}</h4>
                        @if($otherUser->user_type === 'merchant')
                            <small class="text-muted">{{ $otherUser->store_name }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body chat-messages" style="height: 500px; overflow-y: auto;">
                    @foreach($messages as $message)
                        <div class="message mb-3 {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                            <div class="message-content {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }} rounded p-3">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="{{ $message->sender_id == Auth::id() ? 'text-light' : 'text-muted' }}">
                                    {{ $message->created_at->format('h:i A') }}
                                </small>
                                @if($message->product)
                                    <div class="mt-2 p-2 rounded {{ $message->sender_id == Auth::id() ? 'bg-light text-dark' : 'bg-white' }}">
                                        <small>
                                            <i class="fas fa-shopping-bag me-1"></i>
                                            عن منتج: 
                                            <a href="{{ route('products.show', $message->product->id) }}" class="{{ $message->sender_id == Auth::id() ? 'text-primary' : 'text-info' }}">
                                                {{ $message->product->name }}
                                            </a>
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="card-footer">
                    <form action="{{ route('messages.send-conversation', $otherUser->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="اكتب رسالتك هنا..." required>
                            <input type="hidden" name="product_id" value="{{ request('product_id') }}">
                            <button type="submit" class="btn btn-primary">
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
.chat-messages {
    scrollbar-width: thin;
    scrollbar-color: #6366f1 #f1f5f9;
}

.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #6366f1;
    border-radius: 3px;
}

.message.sent {
    text-align: left;
}

.message.received {
    text-align: right;
}

.message-content {
    max-width: 70%;
    display: inline-block;
    word-wrap: break-word;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.querySelector('.chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
});
</script>
@endsection
