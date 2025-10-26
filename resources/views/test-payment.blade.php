<!DOCTYPE html>
<html>
<head>
    <title>Test Payment</title>
</head>
<body>
    <h1>اختبار الدفع المباشر</h1>
    
    <form action="/payment/basic/initiate" method="POST">
        @csrf
        <input type="hidden" name="gateway" value="stripe">
        <button type="submit">اختبار الدفع - Stripe</button>
    </form>

    <form action="/payment/basic/initiate" method="POST">
        @csrf
        <input type="hidden" name="gateway" value="paypal">
        <button type="submit">اختبار الدفع - PayPal</button>
    </form>

    <form action="/payment/basic/initiate" method="POST">
        @csrf
        <input type="hidden" name="gateway" value="moyasar">
        <button type="submit">اختبار الدفع - Moyasar</button>
    </form>

    <hr>
    
    <h2>اختبار رابط النجاح مباشرة:</h2>
    <a href="/payment/success?gateway=stripe&payment_id=test_123&success=true">رابط النجاح التجريبي</a>
</body>
</html>
