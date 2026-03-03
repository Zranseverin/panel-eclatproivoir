FROM php:8.4-fpm

# Arguments définis dans docker-compose.yml
ARG user=laravel
ARG uid=1000

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    sqlite3 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer l'extension Redis pour PHP
RUN pecl install redis && docker-php-ext-enable redis

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer un utilisateur système pour l'application
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Installer Node.js 20 LTS (version supportée)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Créer le répertoire de l'application
WORKDIR /var/www

# ⚠️ IMPORTANT: Ne copiez PAS les fichiers ici - ils seront montés via volume
# Nous allons juste préparer le conteneur sans copier le code

# Changer de propriétaire
USER $user

# Exposer le port 9000
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]