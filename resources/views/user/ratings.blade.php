@extends('layouts.app')

@section('title', 'تقييمات منتجاتي')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="section-title gradient-text">⭐ تقييمات منتجاتي</h1>
            <p class="text-muted">التقييمات والتعليقات على منتجاتك المستعملة</p>
        </div>
    </div>

    @if($ratings->count() > 0)
        <div class="row">
            @foreach($ratings as $rating)
                <div class="col-12 mb-4">
                    <div class="card rating-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <a href="{{ route('products.show', $rating->product->id) }}" class="text-decoration-none">
                                            {{ $rating->product->name }}
                                        </a>
                                    </h5>
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $rating->rating ? 'text-warning' : 'text-light' }}"></i>
                                        @endfor
                                        <span class="ms-2 text-muted">({{ $rating->rating }}/5)</span>
                                    </div>
                                    <p class="card-text">{{ $rating->comment }}</p>
                                    <small class="text-muted">
                                        بواسطة: {{ $rating->user->name }} • 
                                        {{ $rating->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="badge bg-{{ $rating->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $rating->status == 'active' ? 'نشط' : 'مخفي' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-star fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">لا توجد تقييمات</h3>
                <p class="text-muted">لم يتلقى أي من منتجاتك تقييمات بعد</p>
            </div>
        </div>
    @endif
</div>

<style>
.rating-card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.rating-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.empty-state {
    padding: 3rem 1rem;
}
</style>
@endsection
