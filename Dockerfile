FROM php:8.2-apache

# تثبيت extensions المطلوبة لـ Laravel
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

# تغيير DocumentRoot إلى مجلد public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# نسخ ملفات المشروع
COPY . /var/www/html/

# تعيين صلاحيات المجلدات
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

WORKDIR /var/www/html

CMD ["apache2-foreground"]
