# Utiliser l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Installer Composer manuellement
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l’application
COPY . .

# Installer les dépendances Symfony
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Exposer le port 80
EXPOSE 80

# Lancer le serveur Apache
CMD ["apache2-foreground"]
