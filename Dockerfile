FROM php:8.2-apache

# التثبيت الأساسي فقط
RUN apt-get update && apt-get install -y git curl unzip
RUN docker-php-ext-install pdo pdo_mysql mysqli

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات أولاً
COPY . /var/www/html/

# تثبيت dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# إعداد Apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

WORKDIR /var/www/html

CMD ["apache2-foreground"]
