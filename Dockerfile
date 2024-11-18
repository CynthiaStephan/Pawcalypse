# Utiliser l'image officielle PHP avec Apache
FROM php:8.3-apache

# Mettre à jour les paquets et installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install \
    intl \
    mbstring \
    zip \
    mysqli \
    pdo \
    pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copier Composer depuis une image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer les modules Apache nécessaires (par exemple, mod_rewrite)
RUN a2enmod rewrite

# Copier les fichiers de ton projet dans le conteneur
COPY . /var/www/html

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour Apache
EXPOSE 80
