FROM php:8.4-fpm

# Instalar extensiones necesarias
RUN apt-get update \
 && apt-get install -y \
      libpng-dev \
      libonig-dev \
      libxml2-dev \
      zip \
      unzip \
      git \
      curl \
      libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
 && rm -rf /var/lib/apt/lists/*

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar código de Laravel al contenedor
COPY ../.. /var/www

# Asignar permisos
RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
