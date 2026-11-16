# ========================================
# SERVIDOR MULTIPROYECTO LARAVEL
# PHP 8.4.27 + APACHE + NODE.JS 24 + POSTGRESQL
# ========================================

FROM php:8.4.27-apache-bookworm

ENV DEBIAN_FRONTEND=noninteractive

# UID/GID del usuario de Ubuntu (llegan desde compose.yaml / .env)
ARG HOST_UID=1000
ARG HOST_GID=1000

# ========================================
# DEPENDENCIAS DEL SISTEMA
# ========================================

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    ca-certificates \
    gnupg \
    nano \
    procps \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpq-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# ========================================
# EXTENSIONES PHP (pdo_pgsql para PostgreSQL)
# ========================================

RUN docker-php-ext-configure gd \
       --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
       pdo_pgsql \
       pgsql \
       pdo_mysql \
       zip \
       gd \
       intl \
       mbstring \
       bcmath \
       opcache \
       exif \
       pcntl

# ========================================
# NODE.JS 24 LTS + NPM
# ========================================

RUN mkdir -p /etc/apt/keyrings \
    && curl -fsSL \
       https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
       | gpg --dearmor \
       -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_24.x nodistro main" \
       > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# ========================================
# COMPOSER
# ========================================

COPY --from=composer:2 \
    /usr/bin/composer /usr/local/bin/composer

# ========================================
# USUARIO: www-data = tu usuario de Ubuntu
# (archivos a tu nombre y Apache puede escribir en storage/)
# ========================================

RUN groupmod -o -g ${HOST_GID} www-data \
    && usermod -o -u ${HOST_UID} -g ${HOST_GID} www-data \
    && chown -R www-data:www-data /var/www

# ========================================
# APACHE (un proyecto por subdominio .localhost)
# ========================================

RUN a2enmod rewrite headers expires vhost_alias

COPY docker/apache/sites.conf \
    /etc/apache2/sites-available/laravel.conf

COPY docker/inicio /var/www/inicio

RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername \
    && a2dissite 000-default \
    && a2ensite laravel

# ========================================
# CONFIGURACION PHP
# ========================================

COPY docker/php/custom.ini \
    /usr/local/etc/php/conf.d/custom.ini

# ========================================
# DIRECTORIO DE PROYECTOS
# ========================================

WORKDIR /var/www/html

EXPOSE 80 5173

CMD ["apache2-foreground"]