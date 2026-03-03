FROM php:8.2-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Configurer Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copier les fichiers de l'application
COPY . /var/www/html/

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Exposer le port 80
EXPOSE 80

# Démarrer Apache en mode foreground
CMD ["apache2-foreground"]