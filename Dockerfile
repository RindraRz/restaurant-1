# Utilise une image PHP avec Apache
FROM php:8.1-apache

# Installe les dépendances nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    zlib1g-dev \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql xml zip

# Active le module Apache pour Symfony
RUN a2enmod rewrite

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie ton projet Symfony dans le conteneur
COPY . /var/www/html/

# Définit le répertoire de travail
WORKDIR /var/www/html

# Installe les dépendances de Symfony
RUN composer install --no-dev --optimize-autoloader

# Expose le port 80
EXPOSE 80
