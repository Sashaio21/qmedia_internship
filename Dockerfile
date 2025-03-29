# Используем базовый образ с PHP 8.2 и Apache
FROM php:8.2-apache

# Устанавливаем расширения PHP, если они нужны (PDO, MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Устанавливаем Composer (если проект его использует)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем все файлы проекта в контейнер
COPY . .

# Даём права на выполнение
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80 (HTTP)
EXPOSE 80

# Запускаем Apache
CMD ["apache2-foreground"]
