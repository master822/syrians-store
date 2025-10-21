<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار الروابط</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .link-box { background: white; padding: 20px; margin: 10px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        a { display: block; padding: 10px; margin: 5px 0; background: #007bff; color: white; text-decoration: none; border-radius: 5px; text-align: center; }
        a:hover { background: #0056b3; }
        .success { background: #28a745; }
        .danger { background: #dc3545; }
    </style>
</head>
<body>
    <h1>🔧 اختبار روابط إضافة المنتج</h1>
    
    <div class="link-box">
        <h3>الروابط المباشرة:</h3>
        <a href="/products/create" class="success">/products/create (رابط مباشر)</a>
        <a href="http://127.0.0.1:8000/products/create" class="success">http://127.0.0.1:8000/products/create (رابط كامل)</a>
    </div>

    <div class="link-box">
        <h3>روابط Laravel:</h3>
        <a href="{{ url('/products/create') }}" class="success">url('/products/create')</a>
        <a href="{{ route('products.create') }}" class="success">route('products.create')</a>
    </div>

    <div class="link-box">
        <h3>معلومات الجلسة:</h3>
        <p>مستخدم مسجل الدخول: {{ Auth::check() ? 'نعم ✅' : 'لا ❌' }}</p>
        @auth
            <p>اسم المستخدم: {{ Auth::user()->name }}</p>
            <p>نوع المستخدم: {{ Auth::user()->user_type }}</p>
            <p>البريد: {{ Auth::user()->email }}</p>
        @endauth
    </div>

    <div class="link-box">
        <h3>روابط أخرى للاختبار:</h3>
        <a href="/products" class="success">جميع المنتجات</a>
        <a href="/products/new" class="success">المنتجات الجديدة</a>
        <a href="/login" class="danger">تسجيل الدخول (إذا لم تكن مسجلاً)</a>
    </div>
</body>
</html>
