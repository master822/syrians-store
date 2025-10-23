<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Merchanta')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* تحجيم عام */
        body {
            font-size: 14px;
            line-height: 1.5;
            background-color: #ffffff;
            color: #000000;
            transition: all 0.3s ease;
            padding-top: 80px; /* مساحة للنافبار الثابت */
        }
        
        body.dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        
        /* نافبار ثابت */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .nav-link {
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
        }
        
        .dropdown-menu {
            font-size: 0.85rem;
        }
        
        .btn {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }
        
        .card {
            font-size: 0.9rem;
        }
        
        .card-title {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .table {
            font-size: 0.85rem;
        }
        
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-weight: 600;
        }
        
        .display-5 {
            font-size: 2rem;
        }
        
        .display-4 {
            font-size: 2.5rem;
        }

        /* التصميم المخصص */
        .chat-floating-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.5rem;
        }

        .chat-floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }

        .chat-widget {
            position: fixed;
            bottom: 90px;
            left: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            display: none;
            flex-direction: column;
            border: 1px solid #e2e8f0;
        }

        .dark-mode .chat-widget {
            background: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }

        .chat-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .chat-header h6 {
            margin: 0;
            flex-grow: 1;
        }

        .chat-controls {
            display: flex;
            gap: 10px;
        }

        .chat-controls button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 5px;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            max-height: 350px;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .dark-mode .chat-input {
            border-top-color: #4a5568;
        }

        .message {
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 80%;
        }

        .message.received {
            background: #f1f5f9;
            margin-right: auto;
        }

        .dark-mode .message.received {
            background: #4a5568;
            color: #e2e8f0;
        }

        .message.sent {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            margin-left: auto;
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 5px;
        }

        .chat-minimized {
            height: 50px;
        }

        .chat-minimized .chat-messages,
        .chat-minimized .chat-input {
            display: none;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-img {
            height: 30px;
            width: auto;
            margin-right: 8px;
        }

        .dark-mode-toggle {
            background: none;
            border: 2px solid rgba(255,255,255,0.5);
            color: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 8px;
            font-size: 0.9rem;
        }

        .navbar-nav .nav-link {
            padding: 6px 12px;
        }

        /* تحسينات للاستجابة */
        @media (max-width: 768px) {
            body {
                font-size: 13px;
                padding-top: 70px;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }
            
            .display-5 {
                font-size: 1.5rem;
            }

            .chat-widget {
                width: 300px;
                height: 400px;
                left: 10px;
                bottom: 80px;
            }
        }

        /* إصلاح مشكلة الزر المخفي */
        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.5);
            padding: 4px 8px;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            width: 1.2em;
            height: 1.2em;
        }

        /* تحسينات للوضع المظلم */
        .dark-mode .card {
            background-color: #2d3748;
            color: #e2e8f0;
            border-color: #4a5568;
        }

        .dark-mode .text-dark {
            color: #e2e8f0 !important;
        }

        .dark-mode .text-muted {
            color: #a0aec0 !important;
        }

        .dark-mode .bg-light {
            background-color: #2d3748 !important;
        }

        .dark-mode .modal-content {
            background-color: #2d3748;
            color: #e2e8f0;
        }

        .dark-mode .form-control {
            background-color: #4a5568;
            border-color: #718096;
            color: #e2e8f0;
        }

        .dark-mode .form-control:focus {
            background-color: #4a5568;
            border-color: #63b3ed;
            color: #e2e8f0;
        }
    </style>
</head>
<body>
    <!-- الشريط العلوي الثابت -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" alt="Merchanta" class="logo-img">
                Merchanta
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- المنتجات -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            المنتجات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">جميع المنتجات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'clothes') }}">ملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'electronics') }}">إلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'home') }}">أدوات منزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', 'grocery') }}">البقالة</a></li>
                        </ul>
                    </li>
                    
                    <!-- التجار -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            التجار
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('merchants.index') }}">جميع التجار</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'clothes') }}">تجار الملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'electronics') }}">تجار الإلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'home') }}">تجار الأدوات المنزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('merchants.byCategory', 'grocery') }}">تجار البقالة</a></li>
                        </ul>
                    </li>
                    
                    <!-- التخفيضات -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            التخفيضات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('discounts') }}">جميع التخفيضات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('discounts.category', 'clothes') }}">تخفيضات الملابس</a></li>
                            <li><a class="dropdown-item" href="{{ route('discounts.category', 'electronics') }}">تخفيضات الإلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('discounts.category', 'home') }}">تخفيضات الأدوات المنزلية</a></li>
                            <li><a class="dropdown-item" href="{{ route('discounts.category', 'grocery') }}">تخفيضات البقالة</a></li>
                        </ul>
                    </li>
                    
                    <!-- متجر المستعمل -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.used') }}">
                            متجر المستعمل
                        </a>
                    </li>
                </ul>
                
                <!-- الجزء الأيمن من الشريط -->
                <ul class="navbar-nav ms-auto">
                    <!-- زر الوضع المظلم -->
                    <li class="nav-item">
                        <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    
                    @auth
                        <!-- إشعارات الرسائل للتجار -->
                        @if(Auth::user()->user_type === 'merchant')
                            @php
                                $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                                    ->where('is_read', false)
                                    ->count();
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('messages.inbox') }}">
                                    <i class="fas fa-envelope"></i>
                                    @if($unreadCount > 0)
                                        <span class="notification-badge">{{ $unreadCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <small>{{ Auth::user()->name }}</small>
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->user_type === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>لوحة التحكم
                                    </a></li>
                                @elseif(Auth::user()->user_type === 'merchant')
                                    <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.products') }}">
                                        <i class="fas fa-box me-2"></i>منتجاتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.products.create') }}">
                                        <i class="fas fa-plus me-2"></i>إضافة منتج
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.subscription.plans') }}">
                                        <i class="fas fa-rocket me-2"></i>ترقية الخطة
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                        <i class="fas fa-envelope me-2"></i>الرسائل
                                        @if($unreadCount > 0)
                                            <span class="badge bg-primary ms-2">{{ $unreadCount }}</span>
                                        @endif
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products') }}">
                                        <i class="fas fa-box me-2"></i>منتجاتي
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products.create') }}">
                                        <i class="fas fa-plus me-2"></i>إضافة منتج
                                    </a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>الملف الشخصي
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">إنشاء حساب</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- عرض رسائل الـ Session -->
    <div class="container mt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <small>{{ session('success') }}</small>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <small>{{ session('error') }}</small>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show py-2" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <small>{{ session('warning') }}</small>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- المحتوى الرئيسي -->
    <main>
        @yield('content')
    </main>

    <!-- زر الشات العائم -->
    <div class="chat-floating-btn" onclick="toggleChat()">
        <i class="fas fa-comments"></i>
    </div>

    <!-- ويدجت الشات العالمي -->
    <div class="chat-widget" id="chatWidget">
        <div class="chat-header">
            <h6><i class="fas fa-globe me-2"></i>الشات العالمي</h6>
            <div class="chat-controls">
                <button onclick="minimizeChat()"><i class="fas fa-minus"></i></button>
                <button onclick="closeChat()"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message received">
                <div>مرحباً بالجميع في الشات العالمي! 👋</div>
                <div class="message-time">الآن</div>
            </div>
            <div class="message sent">
                <div>أهلاً وسهلاً! 🎉</div>
                <div class="message-time">الآن</div>
            </div>
        </div>
        <div class="chat-input">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="اكتب رسالتك..." id="chatInput">
                <button class="btn btn-primary" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- الفوتر -->
    <footer class="bg-dark text-light py-3 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-2">Merchanta</h6>
                    <p class="small mb-0">منصة شاملة لبيع وشراء المنتجات الجديدة والمستعملة مع أفضل العروض والتخفيضات</p>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-2">روابط سريعة</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('about') }}" class="text-light">عن الموقع</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">اتصل بنا</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-light">الخصوصية</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-2">التواصل</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-phone me-2"></i> +90 555 123 4567</li>
                        <li><i class="fas fa-envelope me-2"></i> info@merchanta.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // إدارة الوضع المظلم - إصلاح كامل
        function toggleDarkMode() {
            const body = document.body;
            const isDarkMode = !body.classList.contains('dark-mode');
            
            body.classList.toggle('dark-mode', isDarkMode);
            localStorage.setItem('darkMode', isDarkMode);
            
            const darkModeIcon = document.querySelector('.dark-mode-toggle i');
            if (darkModeIcon) {
                if (isDarkMode) {
                    darkModeIcon.className = 'fas fa-sun';
                    darkModeIcon.title = 'الوضع الفاتح';
                } else {
                    darkModeIcon.className = 'fas fa-moon';
                    darkModeIcon.title = 'الوضع المظلم';
                }
            }
        }

        // تحميل الوضع المظلم من التخزين المحلي
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            const body = document.body;
            const darkModeIcon = document.querySelector('.dark-mode-toggle i');
            
            if (savedDarkMode === 'true') {
                body.classList.add('dark-mode');
                if (darkModeIcon) {
                    darkModeIcon.className = 'fas fa-sun';
                    darkModeIcon.title = 'الوضع الفاتح';
                }
            } else {
                body.classList.remove('dark-mode');
                if (darkModeIcon) {
                    darkModeIcon.className = 'fas fa-moon';
                    darkModeIcon.title = 'الوضع المظلم';
                }
            }

            // إصلاح مشكلة زر القائمة في الأجهزة الصغيرة
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    this.classList.toggle('collapsed');
                });
            }

            // إضافة ظل للنافبار عند التمرير
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 10) {
                    navbar.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                } else {
                    navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                }
            });

            // تحميل رسائل الشات المحفوظة
            loadChatMessages();
        });

        // إدارة الشات العائم
        let isChatMinimized = false;

        function toggleChat() {
            const chatWidget = document.getElementById('chatWidget');
            if (chatWidget.style.display === 'flex') {
                closeChat();
            } else {
                openChat();
            }
        }

        function openChat() {
            const chatWidget = document.getElementById('chatWidget');
            chatWidget.style.display = 'flex';
            isChatMinimized = false;
            chatWidget.classList.remove('chat-minimized');
            scrollToBottom();
        }

        function closeChat() {
            const chatWidget = document.getElementById('chatWidget');
            chatWidget.style.display = 'none';
        }

        function minimizeChat() {
            const chatWidget = document.getElementById('chatWidget');
            isChatMinimized = !isChatMinimized;
            if (isChatMinimized) {
                chatWidget.classList.add('chat-minimized');
            } else {
                chatWidget.classList.remove('chat-minimized');
                scrollToBottom();
            }
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (message) {
                addMessage(message, 'sent');
                input.value = '';
                
                // حفظ الرسالة في localStorage
                saveMessage(message, 'sent');
                
                // محاكاة رد تلقائي بعد ثانية
                setTimeout(() => {
                    const responses = [
                        'مرحباً! كيف يمكنني مساعدتك؟',
                        'شكراً على رسالتك!',
                        'هذا رائع! 👏',
                        'أهلاً وسهلاً بك في الشات العالمي!'
                    ];
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    addMessage(randomResponse, 'received');
                    saveMessage(randomResponse, 'received');
                }, 1000);
            }
        }

        function addMessage(text, type) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}`;
            
            const now = new Date();
            const timeString = now.toLocaleTimeString('ar-EG', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            messageDiv.innerHTML = `
                <div>${text}</div>
                <div class="message-time">${timeString}</div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            scrollToBottom();
        }

        function scrollToBottom() {
            const messagesContainer = document.getElementById('chatMessages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function saveMessage(text, type) {
            const messages = JSON.parse(localStorage.getItem('chatMessages') || '[]');
            messages.push({
                text: text,
                type: type,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem('chatMessages', JSON.stringify(messages));
        }

        function loadChatMessages() {
            const messages = JSON.parse(localStorage.getItem('chatMessages') || '[]');
            const messagesContainer = document.getElementById('chatMessages');
            
            // احتفظ بالرسائل الافتراضية فقط إذا لم تكن هناك رسائل محفوظة
            if (messages.length === 0) {
                return;
            }
            
            // امسح الرسائل الافتراضية
            messagesContainer.innerHTML = '';
            
            // أضف الرسائل المحفوظة
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${msg.type}`;
                
                const date = new Date(msg.timestamp);
                const timeString = date.toLocaleTimeString('ar-EG', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                messageDiv.innerHTML = `
                    <div>${msg.text}</div>
                    <div class="message-time">${timeString}</div>
                `;
                
                messagesContainer.appendChild(messageDiv);
            });
            
            scrollToBottom();
        }

        // إرسال الرسالة بالضغط على Enter
        document.getElementById('chatInput')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
