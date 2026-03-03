# Projet Hospitalier - Dockerisation

Ce projet est un template de site web hospitalier qui a été dockerisé pour faciliter le déploiement et le développement.

## Structure du projet

Le projet utilise une architecture PHP avec les technologies suivantes :
- PHP 8.2
- Apache
- MySQL 8.0
- phpMyAdmin

## Fichiers Docker créés

1. **Dockerfile** - Configuration de l'image Docker pour l'application PHP
2. **docker-compose.yml** - Orchestration des services (web, database, phpMyAdmin)
3. **apache-config.conf** - Configuration Apache personnalisée
4. **.dockerignore** - Fichiers à ignorer lors du build Docker

## Services inclus

### Web (Port 8080)
- Application PHP/Apache
- Accès via http://localhost:8080

### Database (Port 3308)
- MySQL 8.0
- Base de données: hospital_db
- Utilisateur: hospital_user
- Mot de passe: hospital_password

### phpMyAdmin (Port 8081)
- Interface d'administration MySQL
- Accès via http://localhost:8081

## Instructions d'utilisation

### 1. Démarrer les services

```bash
docker-compose up -d
```

### 2. Accéder aux services

- **Application web**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **Base de données MySQL**: localhost:3308
- **Base de données MySQL**: Port 3308

### 3. Arrêter les services

```bash
docker-compose down
```

### 4. Voir les logs

```bash
docker-compose logs
```

### 5. Reconstruire les images

```bash
docker-compose build --no-cache
```

## Configuration de développement

Le volume dans docker-compose.yml permet le développement en temps réel :
- Les modifications locales sont immédiatement reflétées dans le container
- Pas besoin de reconstruire l'image pour chaque changement

## Variables d'environnement

Les identifiants de base de données peuvent être modifiés dans le fichier `docker-compose.yml` :
- `MYSQL_ROOT_PASSWORD`
- `MYSQL_DATABASE`
- `MYSQL_USER`
- `MYSQL_PASSWORD`

## Structure des dossiers

```
hospital-website/
├── .dockerignore
├── apache-config.conf
├── docker-compose.yml
├── Dockerfile
├── index.php
├── about.php
├── service.php
├── contact.php
├── ...
├── img/
├── partiels/
├── style/
│   ├── css/
│   ├── js/
│  └── lib/
└── mysql-init/ (à créer pour les scripts d'initialisation)
```

## Initialisation de la base de données

Pour initialiser la base de données avec des données de test :

1. Créer un dossier `mysql-init`
2. Ajouter vos scripts SQL (.sql) dans ce dossier
3. Les scripts seront exécutés automatiquement au premier démarrage

Exemple de connexion à la base de données dans votre code PHP :
```php
$host = 'db';
$port = '3306';
$dbname = 'hospital_db';
$username = 'hospital_user';
$password = 'hospital_password';

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
```

## Dépannage

### Problèmes courants

1. **Ports déjà utilisés**:
   ```bash
   # Vérifier les ports utilisés
   netstat -an | grep 8080
   netstat -an | grep 3306
   ```

2. **Permissions**:
   ```bash
   # Réinitialiser les permissions
   docker-compose down -v
   docker-compose up -d
   ```

3. **Connexion à la base de données**:
   - Host: db (dans le réseau Docker)
   - Port: 3306
   - Utiliser les identifiants définis dans docker-compose.yml

## Sécurité

⚠️ **Important**: 
- Ne pas utiliser ces identifiants en production
- Modifier les mots de passe dans un environnement de production
- Configurer SSL/TLS pour les connexions

## Maintenance

Pour mettre à jour les services :
```bash
docker-compose pull
docker-compose up -d
```