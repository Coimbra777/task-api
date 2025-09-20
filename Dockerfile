# Imagem base com PHP 8.3 (ajuste para a versão que você usa)
FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    curl \
    pkg-config \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o driver do MongoDB para PHP
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configura diretório de trabalho
WORKDIR /var/www

# Copia arquivos da aplicação
COPY . /var/www

# Instala dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Expondo a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
