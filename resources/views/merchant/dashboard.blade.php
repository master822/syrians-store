@extends('layouts.app')

@section('title', 'لوحة تحكم التاجر - متجر التخفيضات')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- الشريط الجانبي -->
        <div class="col-lg-3 mb-4">
            <!-- بطاقة الملف الشخصي -->
            <div class="modern-card profile-card animate-fade-in">
                <div class="card-body text-center p-4">
                    <!-- صورة التاجر -->
                    <div class="merchant-avatar mb-3">
                        <img src="{{ $user->getAvatarUrlAttribute() }}" 
                             class="merchant-img" 
                             alt="{{ $user->name }}">
                        <div class="online-status bg-success"></div>
                    </div>
                    
                    <!-- معلومات التاجر -->
                    <h5 class="text-primary mb-2 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->store_name }}</p>
                    
                    <!-- إحصائيات سريعة -->
                    <div class="merchant-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $stats['total_products'] }}</span>
                                <span class="stat-label">المنتجات</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $stats['total_views'] }}</span>
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
                        <a class="nav-link active" href="{{ route('merchant.dashboard') }}">
                            <div class="nav-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <span class="nav-text">لوحة التحكم</span>
                            <div class="nav-badge"></div>
                        </a>
                        <a class="nav-link" href="{{ route('merchant.products') }}">
                            <div class="nav-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <span class="nav-text">منتجاتي</span>
                            <div class="nav-badge">{{ $stats['total_products'] }}</div>
                        </a>
                        <a class="nav-link" href="{{ route('merchant.products.create') }}">
                            <div class="nav-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="nav-text">إضافة منتج</span>
                            <div class="nav-badge new"></div>
                        </a>
                        <a class="nav-link" href="{{ route('merchant.discounts') }}">
                            <div class="nav-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <span class="nav-text">التخفيضات</span>
                            <div class="nav-badge">{{ $products->where('discount_percentage', '>', 0)->count() }}</div>
                        </a>
                        <a class="nav-link" href="{{ route('messages.inbox') }}">
                            <div class="nav-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span class="nav-text">الرسائل</span>
                            <div class="nav-badge">5</div>
                        </a>
                        <a class="nav-link" href="{{ route('merchant.subscription.plans') }}">
                            <div class="nav-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <span class="nav-text">خطط الاشتراك</span>
                            <div class="nav-badge pro"></div>
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
                    <h2 class="text-primary mb-1 fw-bold">مرحباً بعودتك، {{ $user->name }}! </h2>
                    <p class="text-muted mb-0">هذه نظرة على أداء متجرك</p>
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
                                    <h2 class="stat-value text-primary">{{ $stats['total_products'] }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>12%</span>
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
                                    <h2 class="stat-value text-success">{{ $stats['active_products'] }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>8%</span>
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
                                    <h2 class="stat-value text-info">{{ $stats['total_views'] }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>23%</span>
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
                                    <h6 class="stat-title">التقييمات</h6>
                                    <h2 class="stat-value text-warning">{{ $stats['total_ratings'] }}</h2>
                                    <div class="stat-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>15%</span>
                                    </div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <span class="stat-change">متوسط: {{ number_format($stats['average_rating'], 1) }} ⭐</span>
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
                                    <a href="{{ route('merchant.products.create') }}" class="action-btn primary animate-pop">
                                        <div class="action-icon">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>إضافة منتج جديد</h6>
                                            <p>أضف منتجاً جديداً إلى متجرك</p>
                                        </div>
                                        <div class="action-arrow">
                                            <i class="fas fa-arrow-left"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('merchant.discounts.create') }}" class="action-btn success animate-pop" style="animation-delay: 0.1s;">
                                        <div class="action-icon">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>إضافة تخفيض</h6>
                                            <p>أنشئ عرضاً خاصاً للمنتجات</p>
                                        </div>
                                        <div class="action-arrow">
                                            <i class="fas fa-arrow-left"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('merchant.products') }}" class="action-btn info animate-pop" style="animation-delay: 0.2s;">
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
                            <a href="{{ route('merchant.products') }}" class="view-all-btn">
                                عرض الكل
                                <i class="fas fa-arrow-left ms-2"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if($products->count() > 0)
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
                                        @foreach($products->take(5) as $product)
                                        <div class="table-row animate-fade-in">
                                            <div class="table-cell">
                                                <div class="product-info">
                                                    @if($product->images)
                                                        @php
                                                            $images = json_decode($product->images);
                                                            $firstImage = $images[0] ?? null;
                                                        @endphp
                                                        @if($firstImage)
                                                            <img src="{{ asset('storage/' . $firstImage) }}" 
                                                                 class="product-thumb" 
                                                                 alt="{{ $product->name }}">
                                                        @else
                                                            <div class="no-image-thumb">
                                                                <i class="fas fa-image"></i>
                                                            </div>
                                                        @endif
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
                                    <p class="text-muted mb-4">ابدأ بإضافة أول منتج لمتجرك</p>
                                    <a href="{{ route('merchant.products.create') }}" class="btn btn-primary btn-lg">
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

/* البطاقات الحديثة */
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

.profile-card {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.profile-card .text-primary,
.profile-card .text-muted {
    color: rgba(255, 255, 255, 0.9) !important;
}

/* الصورة الشخصية */
.merchant-avatar {
    position: relative;
    display: inline-block;
}

.merchant-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.2);
    object-fit: cover;
    transition: all 0.3s ease;
}

.merchant-img:hover {
    transform: scale(1.1);
    border-color: rgba(255, 255, 255, 0.4);
}

.online-status {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

/* الإحصائيات */
.merchant-stats {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stat-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
}

/* التنقل */
.modern-nav .nav-link {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
    position: relative;
}

.modern-nav .nav-link:hover,
.modern-nav .nav-link.active {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    transform: translateX(5px);
}

.nav-icon {
    width: 24px;
    text-align: center;
    margin-left: 12px;
}

.nav-text {
    flex: 1;
    font-weight: 500;
}

.nav-badge {
    background: var(--success-color);
    color: white;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.nav-badge.new {
    background: var(--warning-color);
}

.nav-badge.pro {
    background: linear-gradient(135deg, #ffd700, #ff6b00);
}

/* بطاقات الإحصائيات */
.stat-card .card-body {
    padding: 24px;
}

.stat-main {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 16px;
}

.stat-content {
    flex: 1;
}

.stat-title {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stat-trend.up {
    background: rgba(72, 187, 120, 0.1);
    color: #48bb78;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-footer {
    border-top: 1px solid var(--border-color);
    padding-top: 12px;
}

.stat-change {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* أزرار الإجراءات */
.action-btn {
    display: flex;
    align-items: center;
    padding: 20px;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-btn:hover {
    transform: translateX(-5px);
    border-color: var(--primary-color);
}

.action-btn.primary:hover {
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(58, 12, 163, 0.1));
}

.action-btn.success:hover {
    background: linear-gradient(135deg, rgba(76, 201, 240, 0.1), rgba(72, 149, 239, 0.1));
}

.action-btn.info:hover {
    background: linear-gradient(135deg, rgba(247, 37, 133, 0.1), rgba(76, 201, 240, 0.1));
}

.action-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-left: 15px;
}

.action-btn.success .action-icon {
    background: linear-gradient(135deg, var(--success-color), var(--info-color));
}

.action-btn.info .action-icon {
    background: linear-gradient(135deg, var(--warning-color), var(--success-color));
}

.action-content {
    flex: 1;
}

.action-content h6 {
    margin-bottom: 4px;
    font-weight: 600;
}

.action-content p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0;
}

.action-arrow {
    color: var(--text-secondary);
    transition: all 0.3s ease;
}

.action-btn:hover .action-arrow {
    transform: translateX(-3px);
    color: var(--primary-color);
}

/* الجدول الحديث */
.table-modern {
    background: var(--card-bg);
    border-radius: 12px;
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.table-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
    gap: 20px;
    padding: 20px;
    align-items: center;
}

.table-header .table-row {
    padding: 15px 20px;
    font-weight: 600;
}

.table-body .table-row {
    border-bottom: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.table-body .table-row:hover {
    background: rgba(67, 97, 238, 0.05);
    transform: translateX(5px);
}

.table-body .table-row:last-child {
    border-bottom: none;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-thumb {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
}

.no-image-thumb {
    width: 50px;
    height: 50px;
    background: var(--border-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
}

.product-details h6 {
    margin-bottom: 4px;
    font-weight: 600;
}

.product-category {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.price-display {
    display: flex;
    align-items: center;
    gap: 8px;
}

.price {
    font-weight: 600;
    color: var(--text-primary);
}

.discount-badge {
    background: var(--warning-color);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.views-display {
    display: flex;
    align-items: center;
    gap: 4px;
    color: var(--text-secondary);
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(72, 187, 120, 0.1);
    color: #48bb78;
}

.status-badge.inactive {
    background: rgba(237, 137, 54, 0.1);
    color: #ed8936;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-action.view {
    background: var(--info-color);
}

.btn-action.edit {
    background: var(--primary-color);
}

.btn-action:hover {
    transform: scale(1.1);
}

/* الحركات */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pop {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

.animate-pop {
    animation: pop 0.5s ease-out forwards;
}

/* الحالة الفارغة */
.empty-state {
    padding: 60px 20px;
}

.empty-icon {
    opacity: 0.5;
}

/* رأس الصفحة */
.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

#themeToggle {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.date-display {
    background: var(--card-bg);
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 500;
    color: var(--text-primary);
    box-shadow: var(--shadow);
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: var(--secondary-color);
    color: white;
    transform: translateX(-3px);
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
    .table-row {
        grid-template-columns: 1fr;
        gap: 10px;
        text-align: center;
    }
    
    .product-info {
        justify-content: center;
        text-align: center;
    }
    
    .action-btn {
        flex-direction: column;
        text-align: center;
    }
    
    .action-icon {
        margin-left: 0;
        margin-bottom: 10px;
    }
    
    .stat-main {
        flex-direction: column;
        text-align: center;
    }
    
    .stat-icon {
        margin-top: 10px;
    }
}
</style>
@endsection
