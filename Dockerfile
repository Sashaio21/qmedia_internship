# Базовый образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем необходимые модули
RUN docker-php-ext-install pdo pdo_mysql

# Включаем mod_rewrite
RUN a2enmod rewrite

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы проекта
COPY . .

# Даем права на выполнение
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80
EXPOSE 80

# Запускаем Apache
CMD ["apache2-foreground"]
