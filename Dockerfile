FROM php:8.2-apache

# التثبيت الأساسي
RUN apt-get update && apt-get install -y \
    git curl unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# إنشاء مجلدات Laravel الأساسية
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# تعيين الصلاحيات بشكل صحيح
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 777 storage/framework storage/logs

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# تنظيف cache Laravel
RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan view:clear || true

# إعداد Apache
RUN a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
