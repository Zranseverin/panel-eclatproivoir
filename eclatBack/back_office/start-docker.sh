#!/bin/bash

echo "========================================"
echo "Démarrage du projet Laravel avec Docker"
echo "========================================"

# Vérifier si Docker est installé
if ! command -v docker &> /dev/null; then
    echo "Erreur : Docker n'est pas installé"
    echo "Veuillez installer Docker"
    exit 1
fi

# Copier le fichier d'environnement si nécessaire
if [ ! -f ".env" ]; then
    echo "Copie du fichier d'environnement..."
    cp ".env.docker" ".env"
    echo "Fichier .env créé"
fi

echo ""
echo "Choisissez le mode de démarrage :"
echo "1. Développement (avec hot-reload)"
echo "2. Production (optimisé)"
echo "3. Arrêter tous les services"
echo "4. Voir les logs"
echo "5. Exécuter les migrations"
echo ""

read -p "Votre choix (1-5) : " choice

case $choice in
    1)
        echo "Démarrage en mode développement..."
        docker-compose -f docker-compose.dev.yml up -d
        echo ""
        echo "Services démarrés !"
        echo "Application : http://localhost:8000"
        echo "Vite dev server : http://localhost:5173"
        echo "MySQL : localhost:3306"
        echo "Redis : localhost:6379"
        ;;
    2)
        echo "Démarrage en mode production..."
        docker-compose up -d
        echo ""
        echo "Services démarrés !"
        echo "Application : http://localhost:8000"
        ;;
    3)
        echo "Arrêt des services..."
        docker-compose -f docker-compose.dev.yml down
        docker-compose down
        echo "Services arrêtés"
        ;;
    4)
        echo "Affichage des logs..."
        echo ""
        echo "Logs des services :"
        docker-compose -f docker-compose.dev.yml logs --tail=50
        ;;
    5)
        echo "Exécution des migrations..."
        docker-compose -f docker-compose.dev.yml exec app php artisan migrate
        ;;
    *)
        echo "Choix invalide"
        ;;
esac

echo ""
read -p "Appuyez sur Entrée pour continuer..."