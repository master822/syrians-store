FROM php:8.2-apache

# تثبيت المتطلبات الأساسية
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# تثبيت إضافات PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring gd zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ جميع ملفات المشروع
COPY . /var/www/html/

# الانتقال إلى مجلد العمل
WORKDIR /var/www/html

# تثبيت dependencies - هذه هي الخطوة الأهم!
RUN composer install --no-dev --optimize-autoloader --no-scripts

# إعداد Apache
RUN a2enmod rewrite

# تغيير DocumentRoot إلى مجلد public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# تعيين صلاحيات المجلدات
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

CMD ["apache2-foreground"]
