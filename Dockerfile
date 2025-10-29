FROM php:8.2-apache

# التثبيت الأساسي
RUN apt-get update && apt-get install -y curl unzip
RUN docker-php-ext-install pdo

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# إنشاء قاعدة بيانات SQLite
RUN touch database/database.sqlite
RUN chmod 666 database/database.sqlite

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# إنشاء مجلدات Laravel
RUN mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache

# تنظيف cache
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# إعداد Apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# الصلاحيات
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache database

CMD ["apache2-foreground"]
