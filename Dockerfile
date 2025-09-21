# Base PHP-FPM
FROM php:8.3-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install pdo_mysql mbstring xml curl zip bcmath

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar MongoDB driver
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalar PHPUnit globalmente
RUN composer global require --dev phpunit/phpunit ^10

# Adicionar composer global bin ao PATH
ENV PATH="$PATH:/root/.composer/vendor/bin"

# Diretório da aplicação
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do projeto
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expor porta PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
