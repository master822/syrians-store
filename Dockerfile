FROM php:8.2-apache

# التثبيت الأساسي
RUN apt-get update && apt-get install -y curl unzip sqlite3
RUN docker-php-ext-install pdo pdo_mysql mysqli

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# إنشاء قاعدة بيانات SQLite
RUN touch database/database.sqlite
RUN chmod 666 database/database.sqlite

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader

# إنشاء مجلدات
RUN mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache

# إعداد Apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# الصلاحيات
RUN chmod -R 775 storage bootstrap/cache database

CMD ["apache2-foreground"]
