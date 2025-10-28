@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- الشريط الجانبي -->
        <div class="col-lg-3 mb-4">
            <!-- بطاقة الملف الشخصي -->
            <div class="modern-card profile-card animate-fade-in">
                <div class="card-body text-center p-4">
                    <!-- صورة المستخدم -->
                    <div class="user-avatar mb-3">
                        <img src="{{ $user->getAvatarUrlAttribute() }}" 
                             class="user-img" 
                             alt="{{ $user->name }}">
                        <div class="online-status bg-success"></div>
                    </div>
                    
                    <!-- معلومات المستخدم -->
                    <h5 class="text-primary mb-2 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">مستخدم عادي</p>
                    
                    <!-- إحصائيات سريعة -->
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $usedProductsCount }}</span>
                                <span class="stat-label">المنتجات</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $viewsCount }}</span>
                                <span class="stat-label">المشاهدات</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قائمة التنقل -->
            <div class="modern-card navigation-card mt-3 animate-fade-in" style="animation-delay: 0.1s;">
                <div class="card-body p-3">
                    <nav class="nav flex-column modern-nav">
                        <a class="nav-link active" href="{{ route('user.dashboard') }}">
                            <div class="nav-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <span class="nav-text">لوحة التحكم</span>
                            <div class="nav-badge"></div>
                        </a>
                        <a class="nav-link" href="{{ route('user.products') }}">
                            <div class="nav-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <span class="nav-text">منتجاتي</span>
                            <div class="nav-badge">{{ $usedProductsCount }}</div>
                        </a>
                        <a class="nav-link" href="{{ route('user.products.create') }}">
                            <div class="nav-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="nav-text">إضافة منتج</span>
                            <div class="nav-badge new"></div>
                        </a>
                        <a class="nav-link" href="{{ route('messages.inbox') }}">
                            <div class="nav-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span class="nav-text">الرسائل</span>
                            <div class="nav-badge">3</div>
                        </a>
                        <a class="nav-link" href="{{ route('profile') }}">
                            <div class="nav-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="nav-text">الملف الشخصي</span>
                            <div class="nav-badge"></div>
                        </a>
                        <a class="nav-link" href="{{ route('change-password') }}">
                            <div class="nav-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <span class="nav-text">تغيير كلمة المرور</span>
                            <div class="nav-badge"></div>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="col-lg-9">
            <!-- رأس الصفحة -->
            <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                <div>
                    <h2 class="text-primary mb-1 fw-bold">مرحباً بعودتك، {{ $user->name }}! 👋</h2>
                    <p class="text-muted mb-0">هذه نظرة عامة على منتجاتك المستعملة</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-outline-primary me-2" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="date-display">
                        <i class="fas fa-calendar me-2"></i>
                        <span id="currentDate"></span>
                    </div>
                </div>
            </div>

            <!-- الإحصائيات -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="modern-card stat-card animate-fade-in" style="animation-delay: 0.3s;">
                        <div class="card-body">
                            <div class="stat-main">
                                <div class="stat-content">
                                    <h6 class="stat-title">إجمالي المنتجات</h6>
                                    <h2 class="stat-value text-primary">{{ $usedProductsCount }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>8%</span>
                                    </div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="stat-change">زيادة عن الشهر الماضي</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="modern-card stat-card animate-fade-in" style="animation-delay: 0.4s;">
                        <div class="card-body">
                            <div class="stat-main">
                                <div class="stat-content">
                                    <h6 class="stat-title">المنتجات النشطة</h6>
                                    <h2 class="stat-value text-success">{{ $activeProductsCount }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>12%</span>
                                    </div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="stat-change">جميع المنتجات مفعلة</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="modern-card stat-card animate-fade-in" style="animation-delay: 0.5s;">
                        <div class="card-body">
                            <div class="stat-main">
                                <div class="stat-content">
                                    <h6 class="stat-title">إجمالي المشاهدات</h6>
                                    <h2 class="stat-value text-info">{{ $viewsCount }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>18%</span>
                                    </div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="stat-change">زيادة في المشاهدات</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="modern-card stat-card animate-fade-in" style="animation-delay: 0.6s;">
                        <div class="card-body">
                            <div class="stat-main">
                                <div class="stat-content">
                                    <h6 class="stat-title">المبيعات الناجحة</h6>
                                    <h2 class="stat-value text-warning">15</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>25%</span>
                                    </div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="stat-change">زيادة في المبيعات</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الإجراءات السريعة -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="modern-card actions-card animate-fade-in" style="animation-delay: 0.7s;">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                الإجراءات السريعة
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="{{ route('user.products.create') }}" class="action-btn primary animate-pop">
                                        <div class="action-icon">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>إضافة منتج مستعمل</h6>
                                            <p>أضف منتجاً مستعملاً للبيع</p>
                                        </div>
                                        <div class="action-arrow">
                                            <i class="fas fa-arrow-left"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('user.products') }}" class="action-btn success animate-pop" style="animation-delay: 0.1s;">
                                        <div class="action-icon">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>إدارة المنتجات</h6>
                                            <p>عرض وتعديل منتجاتك</p>
                                        </div>
                                        <div class="action-arrow">
                                            <i class="fas fa-arrow-left"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('change-password') }}" class="action-btn info animate-pop" style="animation-delay: 0.2s;">
                                        <div class="action-icon">
                                            <i class="fas fa-key"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>تغيير كلمة المرور</h6>
                                            <p>تحديث كلمة المرور الخاصة بك</p>
                                        </div>
                                        <div class="action-arrow">
                                            <i class="fas fa-arrow-left"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المنتجات الحديثة -->
            <div class="row">
                <div class="col-12">
                    <div class="modern-card products-card animate-fade-in" style="animation-delay: 0.8s;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-clock me-2"></i>
                                أحدث المنتجات
                            </h5>
                            <a href="{{ route('user.products') }}" class="view-all-btn">
                                عرض الكل
                                <i class="fas fa-arrow-left ms-2"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recentProducts->count() > 0)
                                <div class="table-modern">
                                    <div class="table-header">
                                        <div class="table-row">
                                            <div class="table-cell">المنتج</div>
                                            <div class="table-cell">السعر</div>
                                            <div class="table-cell">المشاهدات</div>
                                            <div class="table-cell">الحالة</div>
                                            <div class="table-cell">الإجراءات</div>
                                        </div>
                                    </div>
                                    <div class="table-body">
                                        @foreach($recentProducts as $product)
                                        <div class="table-row animate-fade-in">
                                            <div class="table-cell">
                                                <div class="product-info">
                                                    @if($product->has_images)
                                                        <img src="{{ $product->first_image_url }}" 
                                                             class="product-thumb" 
                                                             alt="{{ $product->name }}"
                                                             onerror="this.src='https://via.placeholder.com/50x50/6366f1/ffffff?text=Img'">
                                                    @else
                                                        <div class="no-image-thumb">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                    <div class="product-details">
                                                        <h6 class="product-name">{{ $product->name }}</h6>
                                                        <small class="product-category">{{ $product->category->name ?? 'بدون تصنيف' }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-cell">
                                                <div class="price-display">
                                                    <span class="price">{{ number_format($product->price, 2) }} TL</span>
                                                    @if($product->discount_percentage > 0)
                                                        <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="table-cell">
                                                <div class="views-display">
                                                    <i class="fas fa-eye me-1"></i>
                                                    <span>{{ $product->views }}</span>
                                                </div>
                                            </div>
                                            <div class="table-cell">
                                                <span class="status-badge {{ $product->status === 'active' ? 'active' : 'inactive' }}">
                                                    {{ $product->status === 'active' ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>
                                            <div class="table-cell">
                                                <div class="action-buttons">
                                                    <a href="{{ route('products.show', $product->id) }}" 
                                                       class="btn-action view" title="عرض المنتج">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product->id) }}" 
                                                       class="btn-action edit" title="تعديل المنتج">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action delete" title="حذف المنتج" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon mb-4">
                                        <i class="fas fa-box fa-4x text-muted"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">لا توجد منتجات حتى الآن</h4>
                                    <p class="text-muted mb-4">ابدأ بإضافة أول منتج مستعمل للبيع</p>
                                    <a href="{{ route('user.products.create') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus me-2"></i>إضافة أول منتج
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تبديل الوضع المظلم
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    
    // التحقق من التفضيل المحفوظ
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
    
    themeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            localStorage.setItem('theme', 'light');
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
    });
    
    // عرض التاريخ الحالي
    const currentDate = document.getElementById('currentDate');
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        timeZone: 'Asia/Riyadh'
    };
    currentDate.textContent = now.toLocaleDateString('ar-SA', options);
    
    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.modern-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // تأثيرات للأزرار
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(-5px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});

// إضافة الحركات
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationPlayState = 'running';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.animate-fade-in, .animate-pop');
    animatedElements.forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });
});
</script>

<style>
/* إضافة زر الحذف */
.btn-action.delete {
    background: #e53e3e;
}

.btn-action.delete:hover {
    background: #c53030;
}

/* باقي الأنماط تبقى كما هي */
:root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --success-color: #4cc9f0;
    --info-color: #4895ef;
    --warning-color: #f72585;
    --light-bg: #f8f9fa;
    --dark-bg: #1a1a2e;
    --card-bg: #ffffff;
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --border-color: #e2e8f0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.dark-mode {
    --light-bg: #1a1a2e;
    --card-bg: #16213e;
    --text-primary: #e2e8f0;
    --text-secondary: #a0aec0;
    --border-color: #2d3748;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
}

body {
    background: var(--light-bg);
    transition: all 0.3s ease;
}

/* باقي الأنماط تبقى كما هي */
.modern-card {
    background: var(--card-bg);
    border: none;
    border-radius: 16px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* ... باقي الأنماط تبقى كما هي ... */
</style>
@endsection
