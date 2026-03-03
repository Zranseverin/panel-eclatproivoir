# Dockerisation du projet Laravel

Ce projet est maintenant dockerisé et peut être exécuté dans des conteneurs Docker.

## Prérequis

- Docker Desktop installé sur votre machine
- Docker Compose

## Fichiers Docker créés

- `Dockerfile` - Image de production
- `Dockerfile.dev` - Image de développement
- `docker-compose.yml` - Configuration de production
- `docker-compose.dev.yml` - Configuration de développement
- `docker/nginx/laravel.conf` - Configuration Nginx
- `docker/mysql/my.cnf` - Configuration MySQL
- `.env.docker` - Fichier d'environnement pour Docker
- `.dockerignore` - Fichiers à ignorer lors du build

## Utilisation

### 1. Configuration initiale

Copiez le fichier d'environnement Docker :

```bash
cp .env.docker .env
```

### 2. Démarrage en mode développement

Pour le développement avec hot-reload :

```bash
docker-compose -f docker-compose.dev.yml up -d
```

Cela démarrera :
- **app** : Conteneur PHP-FPM (port 9000)
- **nginx** : Serveur web (port 8000)
- **mysql** : Base de données (port 3306)
- **redis** : Cache (port 6379)
- **node** : Serveur de développement Vite (port 5173)

### 3. Démarrage en mode production

Pour la production :

```bash
docker-compose up -d
```

### 4. Commandes utiles

#### Exécuter des commandes Artisan :

```bash
# En développement
docker-compose -f docker-compose.dev.yml exec app php artisan migrate
docker-compose -f docker-compose.dev.yml exec app php artisan db:seed

# En production
docker-compose exec app php artisan migrate --force
```

#### Exécuter des commandes Composer :

```bash
# En développement
docker-compose -f docker-compose.dev.yml exec app composer install

# En production
docker-compose exec app composer install --no-dev --optimize-autoloader
```

#### Exécuter des commandes NPM :

```bash
# En développement
docker-compose -f docker-compose.dev.yml exec node npm run dev

# En production
docker-compose exec app npm run build
```

#### Accéder aux logs :

```bash
# Logs Nginx
docker-compose logs nginx

# Logs PHP-FPM
docker-compose logs app

# Logs MySQL
docker-compose logs mysql
```

#### Arrêter les conteneurs :

```bash
# En développement
docker-compose -f docker-compose.dev.yml down

# En production
docker-compose down
```

#### Supprimer les volumes (⚠️ attention : cela supprime les données) :

```bash
# En développement
docker-compose -f docker-compose.dev.yml down -v

# En production
docker-compose down -v
```

## Accès à l'application

- **Application web** : http://localhost:8000
- **Base de données MySQL** : localhost:3306
- **Redis** : localhost:6379
- **Vite dev server** : http://localhost:5173 (développement uniquement)

## Configuration de la base de données

Les identifiants de la base de données sont :
- **Hôte** : mysql
- **Base de données** : eclat_back
- **Utilisateur** : laravel
- **Mot de passe** : password123
- **Root password** : root123

## Variables d'environnement importantes

Dans votre fichier `.env`, les variables clés sont :
- `DB_HOST=mysql` (au lieu de localhost)
- `REDIS_HOST=redis` (au lieu de localhost)
- `APP_URL=http://localhost:8000`
- `MAIL_MAILER=smtp` (configuration email Gmail)
- `APP_NAME="Eclat Back Office"`

## Dépannage

### Problèmes courants

1. **Ports déjà utilisés** : Assurez-vous que les ports 8000, 3306, 6379, 5173 ne sont pas utilisés
2. **Permissions** : Sur Linux, vous devrez peut-être ajuster les permissions des volumes
3. **Migrations** : Exécutez toujours les migrations après le premier démarrage

### Commandes de dépannage

```bash
# Reconstruire les images
docker-compose -f docker-compose.dev.yml build --no-cache

# Vérifier l'état des conteneurs
docker-compose -f docker-compose.dev.yml ps

# Accéder au shell du conteneur app
docker-compose -f docker-compose.dev.yml exec app bash

# Redémarrer un service spécifique
docker-compose -f docker-compose.dev.yml restart app
```

## Structure des services

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│    Nginx    │◄──►│  PHP-FPM    │◄──►│   MySQL     │
│   (port     │    │   (port     │    │   (port     │
│   8000)     │    │   9000)     │    │   3306)     │
└─────────────┘    └─────────────┘    └─────────────┘
       ▲                   ▲
       │                   │
┌─────────────┐    ┌─────────────┐
│    Redis    │    │    Node     │
│   (port     │    │   (port     │
│   6379)     │    │   5173)     │
└─────────────┘    └─────────────┘
```

## Bonnes pratiques

1. **Développement** : Utilisez toujours `docker-compose.dev.yml` pour le développement
2. **Production** : Utilisez `docker-compose.yml` pour la production
3. **Sécurité** : Ne commitez jamais vos fichiers `.env` réels
4. **Performance** : Utilisez les volumes pour le développement pour éviter les rebuilds constants
5. **Maintenance** : Nettoyez régulièrement les images et conteneurs inutilisés

## Mise à jour

Pour mettre à jour votre application :

1. Mettez à jour votre code
2. Reconstruisez les images si nécessaire :
   ```bash
   docker-compose -f docker-compose.dev.yml build app
   ```
3. Redémarrez les services :
   ```bash
   docker-compose -f docker-compose.dev.yml up -d
   ```