<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - سوق السوريين</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo i {
            font-size: 48px;
            color: #fff;
            margin-bottom: 10px;
        }
        
        .logo h1 {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: white;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .demo-accounts {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .demo-accounts h3 {
            color: white;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .demo-account {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
            font-size: 12px;
            color: white;
        }
        
        .demo-account:last-child {
            margin-bottom: 0;
        }
        
        .admin { border-right: 3px solid #f39c12; }
        .merchant { border-right: 3px solid #27ae60; }
        .user { border-right: 3px solid #3498db; }
        
        .error-message {
            background: rgba(231, 76, 60, 0.8);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-store"></i>
            <h1>سوق السوريين</h1>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                <input type="email" id="email" name="email" required placeholder="ادخل بريدك الإلكتروني">
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
                <input type="password" id="password" name="password" required placeholder="ادخل كلمة المرور">
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
            </button>
        </form>

        <div class="register-link">
            <a href="{{ url('/register') }}">ليس لديك حساب؟ سجل الآن</a>
        </div>

        <!-- حسابات تجريبية -->
        <div class="demo-accounts">
            <h3><i class="fas fa-key"></i> حسابات تجريبية</h3>
            <div class="demo-account admin">
                <strong>👑 أدمن:</strong> mastersniper822@gmail.com / sniper
            </div>
            <div class="demo-account merchant">
                <strong>🏪 تاجر:</strong> merchant@example.com / password
            </div>
            <div class="demo-account user">
                <strong>👤 مستخدم:</strong> user@example.com / password
            </div>
        </div>
    </div>
</body>
</html>
