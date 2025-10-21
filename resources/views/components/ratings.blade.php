@props(['merchant'])

@php
    // جلب التقييمات من قاعدة البيانات
    $ratings = \App\Models\Rating::where('merchant_id', $merchant->id)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $approvedRatings = $ratings->where('is_approved', true);
    $averageRating = $approvedRatings->avg('rating') ?? 0;
    $totalRatings = $approvedRatings->count();
@endphp

<div class="glass-effect dark:dark-glass rounded-2xl p-6 border border-white/20 dark:border-slate-600/30">
    <!-- رأس قسم التقييمات -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-white dark:text-slate-100">تقييمات التاجر</h3>
            <div class="flex items-center mt-2">
                <!-- متوسط التقييم -->
                <div class="flex items-center ml-4">
                    <span class="text-2xl font-bold text-white dark:text-slate-100">{{ number_format($averageRating, 1) }}</span>
                    <div class="flex mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <i class="fas fa-star text-yellow-400 mx-0.5"></i>
                            @elseif($i - 0.5 <= $averageRating)
                                <i class="fas fa-star-half-alt text-yellow-400 mx-0.5"></i>
                            @else
                                <i class="far fa-star text-yellow-400 mx-0.5"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <span class="text-white/60 dark:text-slate-400 text-sm">({{ $totalRatings }} تقييم)</span>
            </div>
        </div>
        
        <!-- زر إضافة تقييم -->
        <button onclick="openRatingModal({{ $merchant->id }})" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1">
            <i class="fas fa-plus ml-2"></i>
            أضف تقييم
        </button>
    </div>

    <!-- قائمة التقييمات -->
    <div class="space-y-4 max-h-96 overflow-y-auto">
        @forelse($approvedRatings->take(10) as $rating)
            <div class="bg-white/10 dark:bg-slate-700/50 rounded-xl p-4">
                <!-- معلومات المستخدم والتقييم -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center ml-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-white dark:text-slate-100 font-medium">{{ $rating->user->name ?? 'مستخدم' }}</p>
                            <p class="text-white/60 dark:text-slate-400 text-xs">{{ $rating->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i > $rating->rating ? '-o' : '' }} mx-0.5"></i>
                        @endfor
                    </div>
                </div>
                
                <!-- التعليق -->
                <p class="text-white/80 dark:text-slate-300 text-sm leading-relaxed">
                    {{ $rating->comment }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <i class="fas fa-comments text-4xl text-white/40 dark:text-slate-600 mb-3"></i>
                <p class="text-white/60 dark:text-slate-400">لا توجد تقييمات حتى الآن</p>
                <p class="text-white/40 dark:text-slate-500 text-sm mt-1">كن أول من يقيم هذا التاجر</p>
            </div>
        @endforelse
    </div>

    <!-- رسالة التقييمات المحظورة -->
    @if($ratings->where('is_flagged', true)->count() > 0)
        <div class="mt-4 p-3 bg-orange-500/20 border border-orange-500/30 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-orange-400 ml-2"></i>
                <p class="text-orange-300 text-sm">هناك {{ $ratings->where('is_flagged', true)->count() }} تقييم قيد المراجعة</p>
            </div>
        </div>
    @endif
</div>

<!-- نموذج إضافة تقييم -->
<div id="ratingModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="glass-effect dark:dark-glass rounded-2xl p-6 w-full max-w-md mx-4 border border-white/20 dark:border-slate-600/30">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-white dark:text-slate-100">تقييم التاجر</h3>
            <button onclick="closeRatingModal()" class="text-white/60 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="ratingForm" method="POST" action="{{ route('ratings.store') }}">
            @csrf
            <input type="hidden" name="merchant_id" id="merchantId">
            
            <!-- النجوم -->
            <div class="mb-4">
                <label class="block text-white dark:text-slate-200 mb-2">التقييم</label>
                <div class="flex space-x-1 space-x-reverse" id="starRating">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-2xl text-gray-400 hover:text-yellow-400 transition-colors" data-rating="{{ $i }}" onclick="setRating({{ $i }})">
                            <i class="far fa-star"></i>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="selectedRating" value="0" required>
            </div>

            <!-- التعليق -->
            <div class="mb-4">
                <label class="block text-white dark:text-slate-200 mb-2">التعليق</label>
                <textarea 
                    name="comment" 
                    rows="4" 
                    class="w-full px-4 py-3 border border-white/40 dark:border-slate-600/50 rounded-xl focus:ring-2 focus:ring-indigo-300 dark:focus:ring-slate-400 focus:border-transparent transition-all duration-300 bg-white/15 dark:bg-slate-800/50 text-white dark:text-slate-100 placeholder-white/70 dark:placeholder-slate-400 focus:bg-white/25 dark:focus:bg-slate-700/50"
                    placeholder="اكتب تعليقك عن التاجر..."
                    oninput="checkContent(this.value)"
                    required
                ></textarea>
                <div id="contentWarning" class="hidden mt-2 p-2 bg-red-500/20 border border-red-500/30 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-400 ml-2"></i>
                        <p class="text-red-300 text-sm">يحتوي تعليقك على كلمات غير لائقة</p>
                    </div>
                </div>
            </div>

            <!-- زر الإرسال -->
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed"
                id="submitRating"
            >
                <i class="fas fa-paper-plane ml-2"></i>
                إرسال التقييم
            </button>
        </form>
    </div>
</div>

<script>
let currentRating = 0;
let currentMerchantId = 0;

function openRatingModal(merchantId) {
    currentMerchantId = merchantId;
    document.getElementById('merchantId').value = merchantId;
    document.getElementById('ratingModal').classList.remove('hidden');
}

function closeRatingModal() {
    document.getElementById('ratingModal').classList.add('hidden');
    resetRating();
}

function setRating(rating) {
    currentRating = rating;
    document.getElementById('selectedRating').value = rating;
    
    const stars = document.querySelectorAll('#starRating button');
    stars.forEach((star, index) => {
        const starIcon = star.querySelector('i');
        if (index < rating) {
            starIcon.className = 'fas fa-star text-yellow-400';
        } else {
            starIcon.className = 'far fa-star text-gray-400';
        }
    });
}

function resetRating() {
    currentRating = 0;
    document.getElementById('selectedRating').value = 0;
    document.getElementById('ratingForm').reset();
    
    const stars = document.querySelectorAll('#starRating button');
    stars.forEach(star => {
        const starIcon = star.querySelector('i');
        starIcon.className = 'far fa-star text-gray-400';
    });
    
    document.getElementById('contentWarning').classList.add('hidden');
}

function checkContent(text) {
    // قائمة الكلمات غير اللائقة
    const badWords = [
        'كس', 'شرموطة', 'عاهرة', 'زانية', 'قحبة', 'يلعن', 'انيك', 'نيك', 'طيز', 'خرا', 
        'ايري', 'بكسها', 'تبعها', 'حطو بيها', 'يلعن تبعها', 'كس امك', 'انيكك', 'يلعن خرقها',
        'fuck', 'shit', 'bitch', 'asshole', 'motherfucker'
    ];
    
    const hasBadWord = badWords.some(word => text.toLowerCase().includes(word));
    
    const warningDiv = document.getElementById('contentWarning');
    const submitBtn = document.getElementById('submitRating');
    
    if (hasBadWord) {
        warningDiv.classList.remove('hidden');
        submitBtn.disabled = true;
    } else {
        warningDiv.classList.add('hidden');
        submitBtn.disabled = false;
    }
}

// إغلاق النموذج عند النقر خارج المحتوى
document.getElementById('ratingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRatingModal();
    }
});
</script>
