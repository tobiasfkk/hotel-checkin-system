FROM php:8.2-fpm

# Instala Nginx, Supervisor e extensões PHP
RUN apt-get update && apt-get install -y \
    nginx supervisor git unzip curl zip \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring bcmath

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define diretório da aplicação
WORKDIR /app

# Copia aplicação
COPY src/ /app

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Copia config do Nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Copia config do Supervisor
COPY supervisord.conf /etc/supervisord.conf

# Ajusta permissões
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expõe a porta HTTP
EXPOSE 80

# Inicia Nginx e PHP-FPM juntos
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]