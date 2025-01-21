# Pobierz obraz PHP z Apache
FROM php:8.2-fpm

# Zainstaluj wymagane rozszerzenia PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ustaw katalog roboczy
WORKDIR /app

# Eksponuj port dla PHP-FPM
EXPOSE 9000
