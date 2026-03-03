#!/bin/bash

echo "=== Diagnostic Docker pour Eclat Back Office ==="
echo

echo "1. État des conteneurs :"
docker-compose -f docker-compose.dev.yml ps
echo

echo "2. Réseaux Docker :"
docker network ls | grep laravel
echo

echo "3. Informations sur le réseau laravel :"
docker network inspect backoffice_laravel 2>/dev/null || echo "Réseau backoffice_laravel non trouvé"
echo

echo "4. Test de connectivité depuis le conteneur app :"
docker-compose -f docker-compose.dev.yml exec app ping -c 3 mysql 2>/dev/null || echo "Impossible de pinguer mysql"
docker-compose -f docker-compose.dev.yml exec app ping -c 3 redis 2>/dev/null || echo "Impossible de pinguer redis"
echo

echo "5. Services en cours d'exécution :"
docker-compose -f docker-compose.dev.yml ps
echo

echo "6. Logs MySQL (dernières 10 lignes) :"
docker-compose -f docker-compose.dev.yml logs --tail=10 mysql 2>/dev/null || echo "Impossible de récupérer les logs MySQL"
echo

echo "7. Logs Redis (dernières 10 lignes) :"
docker-compose -f docker-compose.dev.yml logs --tail=10 redis 2>/dev/null || echo "Impossible de récupérer les logs Redis"
echo

echo "=== Fin du diagnostic ==="