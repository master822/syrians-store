FROM php:8.2-apache

# الحد الأدنى من التثبيت
RUN apt-get update && apt-get install -y unzip
RUN docker-php-ext-install pdo mysqli

# نسخ الملفات
COPY . /var/www/html/

WORKDIR /var/www/html

# تثبيت Composer يدويًا
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# تثبيت dependencies بدون scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# إعداد Apache بسيط
RUN a2enmod rewrite
RUN echo "<Directory /var/www/html/public>\nAllowOverride All\n</Directory>" >> /etc/apache2/apache2.conf

CMD ["apache2-foreground"]
