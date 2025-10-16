<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .link { display: block; padding: 10px; margin: 5px; background: #007bff; color: white; text-decoration: none; }
        .link:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Test Links</h1>
    
    <a class="link" href="/products">/products (should work)</a>
    <a class="link" href="/products/create">/products/create (requires login)</a>
    <a class="link" href="/test-controller">/test-controller (direct test)</a>
    
    <hr>
    
    <h2>Login Links:</h2>
    <a class="link" href="/login">Login Page</a>
    
    <hr>
    
    <h2>Debug Info:</h2>
    <p>Logged in: {{ Auth::check() ? 'YES' : 'NO' }}</p>
    @auth
    <p>User: {{ Auth::user()->name }}</p>
    <p>Type: {{ Auth::user()->user_type }}</p>
    @endauth
</body>
</html>
