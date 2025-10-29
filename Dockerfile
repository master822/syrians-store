FROM php:8.2-apache

# التثبيت الأساسي
RUN apt-get update && apt-get install -y curl unzip
RUN docker-php-ext-install pdo pdo_mysql mysqli

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# إنشاء مجلدات Laravel الأساسية
RUN mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache

# إنشاء قاعدة بيانات SQLite
RUN touch database/database.sqlite
RUN chmod 666 database/database.sqlite

# تشغيل migrations (إذا لديك)
RUN php artisan migrate --force 2>/dev/null || true

# تنظيف cache
RUN php artisan config:clear 2>/dev/null || true
RUN php artisan cache:clear 2>/dev/null || true

# إعداد Apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# الصلاحيات
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache database

CMD ["apache2-foreground"]
