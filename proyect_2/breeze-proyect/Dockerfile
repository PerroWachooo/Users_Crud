# Imagen base oficial PHP
FROM php:8.2-fpm

# Instala utilidades y extensiones requeridas por Laravel y Vue
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nodejs

# Instala extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Setea el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la app
COPY . .

# Instala dependencias PHP
RUN composer install --no-scripts --no-autoloader

# Instala dependencias NPM
RUN npm install && npm run build

# Genera autoload de Composer
RUN composer dump-autoload

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto
EXPOSE 8000

# Usa el servidor embebido de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]