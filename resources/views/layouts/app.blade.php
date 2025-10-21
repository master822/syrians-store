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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        /* تصميم زر الشات العائم */
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
        }

        .chat-floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }

        .chat-floating-btn i {
            font-size: 1.5rem;
        }

        /* تصميم نافذة الشات */
        .chat-window {
            position: fixed;
            bottom: 90px;
            left: 20px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 1001;
            display: none;
            flex-direction: column;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .chat-window.active {
            display: flex;
        }

        .chat-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h6 {
            margin: 0;
            font-weight: 600;
        }

        .chat-controls {
            display: flex;
            gap: 5px;
        }

        .chat-controls button {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-controls button:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }

        .chat-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .message {
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 15px;
            position: relative;
        }

        .message.own {
            align-self: flex-end;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message.other {
            align-self: flex-start;
            background: white;
            color: #333;
            border: 1px solid #e2e8f0;
            border-bottom-left-radius: 5px;
        }

        .message-sender {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 5px;
            text-align: right;
        }

        .chat-input {
            padding: 15px;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        .chat-input .input-group {
            gap: 10px;
        }

        .chat-input input {
            border-radius: 25px;
            padding: 10px 15px;
        }

        .chat-input button {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* الوضع المظلم */
        .dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark-mode .navbar {
            background-color: #2d3748 !important;
        }

        .dark-mode .card {
            background-color: #2d3748;
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

        .dark-mode .chat-window {
            background: #2d3748;
            border-color: #4a5568;
        }

        .dark-mode .chat-body {
            background: #1a202c;
        }

        .dark-mode .chat-messages {
            background: #2d3748;
        }

        .dark-mode .message.other {
            background: #4a5568;
            color: #e2e8f0;
            border-color: #718096;
        }

        .dark-mode .chat-input {
            background: #2d3748;
            border-color: #4a5568;
        }

        .dark-mode .chat-input input {
            background: #4a5568;
            border-color: #718096;
            color: #e2e8f0;
        }

        .dark-mode .chat-input input::placeholder {
            color: #a0aec0;
        }

        .dark-mode footer {
            background-color: #2d3748 !important;
        }

        /* تحسينات للشريط العلوي */
        .navbar-nav .dropdown-menu {
            text-align: right;
        }

        .dark-mode-toggle {
            background: none;
            border: 2px solid rgba(255,255,255,0.5);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background: rgba(255,255,255,0.1);
            transform: scale(1.1);
        }

        .logo-img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- الشريط العلوي -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
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
                        <button class="dark-mode-toggle me-3" onclick="toggleDarkMode()">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->user_type === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                                @elseif(Auth::user()->user_type === 'merchant')
                                    <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">لوحة التحكم</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">لوحة التحكم</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}">الملف الشخصي</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
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

    <!-- المحتوى الرئيسي -->
    <main>
        @yield('content')
    </main>

    <!-- الفوتر -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Merchanta</h5>
                    <p>منصة شاملة لبيع وشراء المنتجات الجديدة والمستعملة مع أفضل العروض والتخفيضات</p>
                </div>
                <div class="col-md-3">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="text-light">عن الموقع</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">اتصل بنا</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-light">الخصوصية</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>التواصل</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> +90 555 123 4567</li>
                        <li><i class="fas fa-envelope me-2"></i> info@merchanta.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- زر الشات العائم -->
    @auth
    <button class="chat-floating-btn" onclick="toggleChatWindow()">
        <i class="fas fa-comments"></i>
    </button>

    <!-- نافذة الشات -->
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <h6>الشات العالمي</h6>
            <div class="chat-controls">
                <button onclick="minimizeChat()">
                    <i class="fas fa-minus"></i>
                </button>
                <button onclick="closeChat()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="chat-body">
            <div class="chat-messages" id="chatMessages">
                <div class="text-center text-muted py-4">
                    <i class="fas fa-comments fa-2x mb-3"></i>
                    <p>مرحباً في الشات العالمي</p>
                    <small>ابدأ المحادثة مع المستخدمين الآخرين</small>
                </div>
            </div>
            <div class="chat-input">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="اكتب رسالتك..." id="chatMessageInput">
                    <button class="btn btn-primary" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // إدارة نافذة الشات
        let isChatOpen = false;
        let isChatMinimized = false;

        function toggleChatWindow() {
            const chatWindow = document.getElementById('chatWindow');
            if (isChatOpen && !isChatMinimized) {
                closeChat();
            } else {
                openChat();
            }
        }

        function openChat() {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.classList.add('active');
            isChatOpen = true;
            isChatMinimized = false;
        }

        function minimizeChat() {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.classList.remove('active');
            isChatMinimized = true;
        }

        function closeChat() {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.classList.remove('active');
            isChatOpen = false;
            isChatMinimized = false;
        }

        function sendMessage() {
            const input = document.getElementById('chatMessageInput');
            const message = input.value.trim();
            
            if (message) {
                // إرسال الرسالة
                console.log('إرسال رسالة:', message);
                
                // إضافة الرسالة للشات
                addMessageToChat('أنت', message, true);
                input.value = '';
                
                // محاكاة رد تلقائي بعد ثانية
                setTimeout(() => {
                    const responses = [
                        'مرحباً! كيف يمكنني مساعدتك؟',
                        'شكراً على رسالتك!',
                        'هذا رائع!',
                        'أهلاً وسهلاً بك في الشات العالمي'
                    ];
                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    addMessageToChat('مستخدم آخر', randomResponse, false);
                }, 1000);
            }
        }

        function addMessageToChat(sender, message, isOwn = false) {
            const chatMessages = document.getElementById('chatMessages');
            
            // إزالة الرسالة الترحيبية إذا كانت موجودة
            if (chatMessages.children.length === 1 && chatMessages.children[0].classList.contains('text-center')) {
                chatMessages.innerHTML = '';
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isOwn ? 'own' : 'other'}`;
            
            const now = new Date();
            const time = now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0');
            
            messageDiv.innerHTML = `
                ${!isOwn ? `<div class="message-sender">${sender}</div>` : ''}
                <div>${message}</div>
                <div class="message-time">${time}</div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // إدارة الوضع المظلم
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');
            
            // حفظ التفضيل في localStorage
            const isDarkMode = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            
            // تحديث أيقونة الوضع المظلم
            const darkModeIcon = document.querySelector('.dark-mode-toggle i');
            if (darkModeIcon) {
                if (isDarkMode) {
                    darkModeIcon.className = 'fas fa-sun';
                } else {
                    darkModeIcon.className = 'fas fa-moon';
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
                }
            }

            // إدخال الرسالة بالزر Enter
            document.getElementById('chatMessageInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
