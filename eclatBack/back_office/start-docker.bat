@echo off
echo ========================================
echo Démarrage du projet Laravel avec Docker
echo ========================================

REM Vérifier si Docker est installé
docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Erreur : Docker n'est pas installé ou n'est pas dans le PATH
    echo Veuillez installer Docker Desktop
    pause
    exit /b 1
)

REM Copier le fichier d'environnement si nécessaire
if not exist ".env" (
    echo Copie du fichier d'environnement...
    copy ".env.docker" ".env"
    echo Fichier .env créé
)

echo.
echo Choisissez le mode de démarrage :
echo 1. Développement (avec hot-reload)
echo 2. Production (optimisé)
echo 3. Arrêter tous les services
echo 4. Voir les logs
echo 5. Exécuter les migrations
echo.

set /p choice="Votre choix (1-5) : "

if "%choice%"=="1" (
    echo Démarrage en mode développement...
    docker-compose -f docker-compose.dev.yml up -d
    echo.
    echo Services démarrés !
    echo Application : http://localhost:8000
    echo Vite dev server : http://localhost:5173
    echo MySQL : localhost:3306
    echo Redis : localhost:6379
) else if "%choice%"=="2" (
    echo Démarrage en mode production...
    docker-compose up -d
    echo.
    echo Services démarrés !
    echo Application : http://localhost:8000
) else if "%choice%"=="3" (
    echo Arrêt des services...
    docker-compose -f docker-compose.dev.yml down
    docker-compose down
    echo Services arrêtés
) else if "%choice%"=="4" (
    echo Affichage des logs...
    echo.
    echo Logs des services :
    docker-compose -f docker-compose.dev.yml logs --tail=50
) else if "%choice%"=="5" (
    echo Exécution des migrations...
    docker-compose -f docker-compose.dev.yml exec app php artisan migrate
) else (
    echo Choix invalide
)

echo.
pause