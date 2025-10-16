<!DOCTYPE html>
<html>
<head>
    <title>Debug Routes</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .link { display: block; padding: 10px; margin: 5px; text-decoration: none; border-radius: 5px; }
        .working { background: #28a745; color: white; }
        .protected { background: #ffc107; color: black; }
        .problem { background: #dc3545; color: white; }
        .info { background: #17a2b8; color: white; }
    </style>
</head>
<body>
    <h1>🔧 Debug Routes</h1>
    
    <h2>Public Routes (Should Work):</h2>
    <a class="link working" href="/">Home</a>
    <a class="link working" href="/products">All Products</a>
    <a class="link working" href="/products/new">New Products</a>
    
    <h2>Protected Routes (Need Login):</h2>
    <a class="link protected" href="/products/create">/products/create</a>
    
    <h2>Test Routes:</h2>
    <a class="link info" href="/test-simple-page">Test Simple Page</a>
    <a class="link info" href="/test-create-simple">Test Create Simple</a>
    <a class="link info" href="/test-view">Test View Exists</a>
    
    <h2>User Info:</h2>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
        <p><strong>Logged In:</strong> {{ Auth::check() ? '✅ YES' : '❌ NO' }}</p>
        @auth
        <p><strong>User:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Type:</strong> {{ Auth::user()->user_type }}</p>
        @endauth
    </div>
    
    <h2>Manual Test Links:</h2>
    <p>Copy and paste these in your browser:</p>
    <div style="background: #e9ecef; padding: 10px; border-radius: 5px;">
        <code>http://127.0.0.1:8000/products/create</code><br>
        <code>http://localhost:8000/products/create</code>
    </div>
</body>
</html>
