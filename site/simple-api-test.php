<?php
// Test API simple - Logo et Configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔌 Test de l'API Laravel</h2>";
echo "<p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Configuration
$apiBaseUrl = 'http://host.docker.internal:8000/api';
$configEndpoint = '/v1/config';
$fullUrl = $apiBaseUrl . $configEndpoint;

echo "<h3>1. Informations de connexion</h3>";
echo "<p><strong>API Base URL:</strong> <code>$apiBaseUrl</code></p>";
echo "<p><strong>Endpoint:</strong> <code>$configEndpoint</code></p>";
echo "<p><strong>URL complète:</strong> <code>$fullUrl</code></p>";
echo "<hr>";

// Test de l'appel API
echo "<h3>2. Résultat de l'appel API</h3>";

try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $errno = curl_errno($ch);
    curl_close($ch);
    
    echo "<p><strong>Code HTTP:</strong> <span style='color: blue; font-weight: bold;'>$httpCode</span></p>";
    
    if ($errno) {
        echo "<p style='color: red;'><strong>Erreur cURL (errno: $errno):</strong> $error</p>";
        
        if ($errno === CURLE_COULDNT_CONNECT) {
            echo "<div style='background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 10px 0;'>";
            echo "<strong>⚠️ Problème de connexion Docker détecté !</strong><br>";
            echo "Solutions possibles :<br>";
            echo "1. Vérifiez que le conteneur Laravel est en cours d'exécution : <code>docker-compose ps</code><br>";
            echo "2. Essayez avec l'IP directe du conteneur<br>";
            echo "3. Vérifiez que host.docker.internal est résolu correctement";
            echo "</div>";
        }
    }
    
    if ($response) {
        echo "<h4>Réponse brute :</h4>";
        echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto;'>" . htmlspecialchars($response) . "</pre>";
        
        // Décoder le JSON
        $data = json_decode($response, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            echo "<h4>Réponse décodée (JSON valide ✓) :</h4>";
            echo "<pre style='background: #f9f9f9; padding: 10px; border-radius: 5px; overflow-x: auto;'>" . print_r($data, true) . "</pre>";
            
            // Validation de la structure
            if (isset($data['success']) && $data['success']) {
                echo "<p style='color: green; font-weight: bold;'>✓ API retourne success = true</p>";
                
                if (isset($data['data'])) {
                    echo "<h4>Données de configuration :</h4>";
                    echo "<ul>";
                    echo "<li><strong>Logo Path:</strong> <code>" . htmlspecialchars($data['data']['logo_path'] ?? 'N/A') . "</code></li>";
                    echo "<li><strong>Alt Text:</strong> " . htmlspecialchars($data['data']['alt_text'] ?? 'N/A') . "</li>";
                    echo "<li><strong>Site Title:</strong> " . htmlspecialchars($data['data']['site_title'] ?? 'N/A') . "</li>";
                    echo "</ul>";
                    
                    // Tester l'affichage du logo
                    $logoPath = $data['data']['logo_path'] ?? '';
                    if ($logoPath) {
                        echo "<h4>Test d'affichage du logo :</h4>";
                        
                        // Construire l'URL complète
                        if (strpos($logoPath, 'http') !== 0) {
                            $logoUrl = 'http://localhost:8000' . $logoPath;
                        } else {
                            $logoUrl = $logoPath;
                        }
                        
                        echo "<p><strong>URL du logo:</strong> <code>$logoUrl</code></p>";
                        
                        // Vérifier si l'image est accessible
                        $imgCheck = @get_headers($logoUrl);
                        if ($imgCheck && strpos($imgCheck[0], '200')) {
                            echo "<p style='color: green;'>✓ Image accessible</p>";
                            echo "<img src='$logoUrl' alt='Logo' style='max-width: 300px; border: 2px solid #28a745; border-radius: 5px;'>";
                        } else {
                            echo "<p style='color: red;'>✗ Image non accessible</p>";
                            echo "<p>Essayez d'ouvrir : <a href='$logoUrl' target='_blank'>$logoUrl</a></p>";
                        }
                    }
                } else {
                    echo "<p style='color: red;'>✗ Clé 'data' manquante dans la réponse</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ API retourne success = false ou absent</p>";
            }
        } else {
            echo "<p style='color: red;'><strong>Erreur JSON:</strong> " . json_last_error_msg() . "</p>";
            echo "<p>La réponse n'est pas du JSON valide</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Aucune réponse reçue</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Exception:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";

// Test avec file_get_contents (alternative)
echo "<h3>3. Test avec file_get_contents (si activé)</h3>";
if (ini_get('allow_url_fopen')) {
    echo "<p><code>allow_url_fopen</code> est activé ✓</p>";
    
    try {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'ignore_errors' => true
            ]
        ]);
        
        $result = @file_get_contents($fullUrl, false, $context);
        
        if ($result !== FALSE) {
            echo "<p style='color: green;'>✓ file_get_contents fonctionne</p>";
            $testData = json_decode($result, true);
            if (isset($testData['success'])) {
                echo "<p style='color: green;'>✓ Données valides récupérées</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ file_get_contents a échoué</p>";
            echo "<p>Erreurs: " . print_r($http_response_header ?? 'Aucune info', true) . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Erreur: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ <code>allow_url_fopen</code> est désactivé</p>";
}

echo "<hr>";

// Résumé et recommandations
echo "<h3>4. Résumé et actions recommandées</h3>";

if ($httpCode === 200 && $response && isset($data['success']) && $data['success']) {
    echo "<div style='background: #d4edda; padding: 15px; border-left: 4px solid #28a745;'>";
    echo "<h4 style='color: #155724; margin-top: 0;'>✅ TOUT FONCTIONNE CORRECTEMENT !</h4>";
    echo "<p>L'API Laravel est accessible et fonctionnelle.</p>";
    echo "<p>Le site frontal peut récupérer les données de configuration.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-left: 4px solid #dc3545;'>";
    echo "<h4 style='color: #721c24; margin-top: 0;'>❌ PROBLÈME DÉTECTÉ</h4>";
    echo "<p><strong>Problèmes identifiés :</strong></p>";
    echo "<ul>";
    
    if ($errno) {
        echo "<li>Erreur de connexion réseau (cURL errno: $errno)</li>";
    }
    if ($httpCode !== 200) {
        echo "<li>Code HTTP incorrect : $httpCode (attendu: 200)</li>";
    }
    if (!$response) {
        echo "<li>Aucune réponse de l'API</li>";
    }
    if ($response && (!isset($data['success']) || !$data['success'])) {
        echo "<li>Réponse API invalide ou erreur métier</li>";
    }
    
    echo "</ul>";
    echo "<p><strong>Solutions à essayer :</strong></p>";
    echo "<ol>";
    echo "<li>Vérifiez que Docker tourne : <code>docker-compose ps</code></li>";
    echo "<li>Vérifiez que le conteneur app est actif : <code>docker-compose exec app echo 'OK'</code></li>";
    echo "<li>Testez l'API directement : <a href='http://localhost:8000/api/v1/config' target='_blank'>http://localhost:8000/api/v1/config</a></li>";
    echo "<li>Vérifiez les logs Laravel : <code>docker-compose logs app</code></li>";
    echo "<li>Redémarrez les conteneurs : <code>docker-compose restart</code></li>";
    echo "</ol>";
    echo "</div>";
}

?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 20px;
        background: #f8f9fa;
    }
    h2 { color: #2c3e50; }
    h3 { color: #34495e; margin-top: 30px; }
    h4 { color: #7f8c8d; }
    code { 
        background: #ecf0f1; 
        padding: 2px 6px; 
        border-radius: 3px;
        color: #e74c3c;
    }
    pre { 
        background: #2c3e50; 
        color: #ecf0f1;
        padding: 15px; 
        border-radius: 5px; 
        overflow-x: auto; 
        font-size: 12px;
    }
    p { margin: 10px 0; line-height: 1.6; }
    ul, ol { margin: 10px 0; padding-left: 30px; }
    li { margin: 5px 0; }
</style>
