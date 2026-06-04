# Imagem base alinhada ao projeto de referência
FROM php:8.3-fpm-bookworm

# Dependências de sistema para as extensões PHP do Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer 2.9.x (mesma linha do projeto de referência)
COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

# Mantém o cache do Composer fora do diretório do projeto
ENV COMPOSER_HOME=/tmp/composer

# Roda como usuário não-root mapeado ao host (evita problemas de permissão)
ARG UID=1000
ARG GID=1000
RUN groupmod -g ${GID} www-data \
    && usermod -u ${UID} -g ${GID} www-data

WORKDIR /var/www

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
