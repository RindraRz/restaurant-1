FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    zlib1g-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql xml zip

# Configurer pkg-config pour libzip
ENV PKG_CONFIG_PATH /usr/lib/x86_64-linux-gnu/pkgconfig
ENV LIBZIP_CFLAGS "-I/usr/include"
ENV LIBZIP_LIBS "-L/usr/lib/x86_64-linux-gnu -lzip"

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur non-root
RUN useradd -m appuser && chown -R appuser /var/www/html

# Basculer vers l'utilisateur non-root
USER appuser

# Copier les fichiers de l'application
COPY --chown=appuser . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Vider manuellement le cache
RUN rm -rf var/cache/* var/log/*
RUN mkdir -p var/cache var/log
RUN chmod -R 777 var/cache var/log

# Installer les dépendances Composer (sans scripts)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# Exécuter les scripts Symfony manuellement
RUN php bin/console cache:clear --env=prod

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Lancer PHP-FPM
CMD ["php-fpm"]