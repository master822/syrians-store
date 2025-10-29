FROM php:8.2-apache

# تثبيت المتطلبات الأساسية
RUN apt-get update && apt-get install -y \
    git curl unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader

# نسخ .env.example إلى .env إذا لم يوجد .env
RUN cp .env.example .env 2>/dev/null || true

# إعداد Apache
RUN a2enmod rewrite

# تغيير DocumentRoot إلى مجلد public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# تعيين الصلاحيات
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# إنشاء قاعدة بيانات SQLite إذا لم توجد
RUN touch database/database.sqlite

CMD ["apache2-foreground"]
