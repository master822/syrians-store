#!/bin/bash
echo "=== التحقق من إصلاح APP_KEY ==="

cd /var/www/html/syrians

echo "1. فحص ملف .env:"
if [ -f .env ]; then
    echo "✅ ملف .env موجود"
    if grep -q "APP_KEY=base64:" .env; then
        echo "✅ APP_KEY موجود وصحيح"
        grep "APP_KEY" .env
    else
        echo "❌ APP_KEY غير موجود"
        echo "جاري الإصلاح..."
        php artisan key:generate
    fi
else
    echo "❌ ملف .env غير موجود"
fi

echo "2. فحص قاعدة البيانات:"
php artisan migrate:status 2>/dev/null && echo "✅ اتصال قاعدة البيانات ناجح" || echo "⚠️  مشكلة في الاتصال بقاعدة البيانات"

echo "3. فحص التطبيق:"
php artisan tinker --execute="echo 'Laravel يعمل بشكل صحيح';" 2>/dev/null && echo "✅ Laravel يعمل" || echo "❌ مشكلة في Laravel"

echo "=== انتهى الفحص ==="
