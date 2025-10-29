FROM php:8.2-apache

# تثبيت extensions المطلوبة لـ Laravel
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

# نسخ ملفات المشروع
COPY . /var/www/html/

# تعيين صلاحيات المجلدات
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# تعيين المسار الأساسي
WORKDIR /var/www/html

# تشغيل Apache
CMD ["apache2-foreground"]
