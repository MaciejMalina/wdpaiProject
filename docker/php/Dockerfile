# Pobierz obraz PHP z Apache
FROM php:8.1-fpm

# Instalacja potrzebnych bibliotek, w tym pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Ustaw katalog roboczy
WORKDIR /app

# Eksponuj port dla PHP-FPM
EXPOSE 9000
