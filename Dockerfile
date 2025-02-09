# Utilisation de l'image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    unzip git libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers de l'application
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Symfony
RUN composer install --no-dev --optimize-autoloader

# Exposer le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
