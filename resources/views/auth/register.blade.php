<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - سوق السوريين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
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
        
        .user-type-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .user-type-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .user-type-btn.active {
            background: rgba(255, 255, 255, 0.2);
            border-color: #4facfe;
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
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .merchant-fields {
            display: none;
        }
        
        .error-message {
            background: rgba(231, 76, 60, 0.8);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        
        .field-required::after {
            content: " *";
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <i class="fas fa-store"></i>
            <h1>سوق السوريين</h1>
        </div>

        @if($errors->any())
            <div class="error-message">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            
            <input type="hidden" name="user_type" id="user_type" value="{{ $userType ?? 'user' }}">
            
            <div class="user-type-buttons">
                <div class="user-type-btn {{ ($userType ?? 'user') == 'user' ? 'active' : '' }}" onclick="setUserType('user')">
                    👤 مستخدم عادي
                </div>
                <div class="user-type-btn {{ ($userType ?? 'user') == 'merchant' ? 'active' : '' }}" onclick="setUserType('merchant')">
                    🏪 تاجر
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="field-required">الاسم الكامل</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="ادخل اسمك الكامل">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="field-required">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="ادخل بريدك الإلكتروني">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="field-required">كلمة المرور</label>
                        <input type="password" id="password" name="password" required placeholder="ادخل كلمة المرور">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation" class="field-required">تأكيد كلمة المرور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="اعد إدخال كلمة المرور">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="field-required">رقم الهاتف</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="ادخل رقم هاتفك">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city" class="field-required">المدينة</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required placeholder="ادخل مدينتك">
                    </div>
                </div>
            </div>

            <!-- حقول التاجر (تظهر فقط عند اختيار تاجر) -->
            <div class="merchant-fields" id="merchantFields">
                <div class="form-group">
                    <label for="store_name" class="field-required">اسم المتجر</label>
                    <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" placeholder="ادخل اسم المتجر">
                </div>

                <div class="form-group">
                    <label for="store_category" class="field-required">فئة المتجر</label>
                    <select id="store_category" name="store_category">
                        <option value="">اختر فئة المتجر</option>
                        <option value="clothes" {{ old('store_category') == 'clothes' ? 'selected' : '' }}>ملابس</option>
                        <option value="electronics" {{ old('store_category') == 'electronics' ? 'selected' : '' }}>إلكترونيات</option>
                        <option value="home" {{ old('store_category') == 'home' ? 'selected' : '' }}>أدوات منزلية</option>
                        <option value="food" {{ old('store_category') == 'food' ? 'selected' : '' }}>بقالة</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="store_description">وصف المتجر</label>
                    <textarea id="store_description" name="store_description" rows="3" placeholder="صف متجرك...">{{ old('store_description') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> إنشاء حساب
            </button>
        </form>

        <div class="login-link">
            <a href="{{ url('/login') }}">لديك حساب بالفعل؟ سجل الدخول</a>
        </div>
    </div>

    <script>
        function setUserType(type) {
            document.getElementById('user_type').value = type;
            
            // تحديث الأزرار النشطة
            document.querySelectorAll('.user-type-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // إظهار/إخفاء حقول التاجر
            const merchantFields = document.getElementById('merchantFields');
            if (type === 'merchant') {
                merchantFields.style.display = 'block';
                // جعل الحقول مطلوبة للتاجر
                document.getElementById('store_name').required = true;
                document.getElementById('store_category').required = true;
            } else {
                merchantFields.style.display = 'none';
                // إزالة الشرط من الحقول
                document.getElementById('store_name').required = false;
                document.getElementById('store_category').required = false;
            }
        }

        // تهيئة النوع عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            const userType = '{{ $userType ?? 'user' }}';
            setUserType(userType);
        });
    </script>
</body>
</html>
