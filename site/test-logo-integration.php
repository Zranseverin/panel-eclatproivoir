<?php
// Test de vérification complète - Logo et API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔍 Test Complet - Intégration Logo API</h2>";
echo "<hr>";

// Test 1: Vérifier la base de données
echo "<h3>Test 1: Données en base</h3>";
try {
    $pdo = new PDO("mysql:host=localhost;port=3308;dbname=eclat_back", "laravel", "password123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT id, logo_path, alt_text, site_title FROM config_logo ORDER BY created_at DESC LIMIT 1");
    $config = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($config) {
        echo "<p style='color: green;'>✓ Configuration trouvée</p>";
        echo "<ul>";
        echo "<li><strong>ID:</strong> " . htmlspecialchars($config['id']) . "</li>";
        echo "<li><strong>Logo Path:</strong> <code>" . htmlspecialchars($config['logo_path']) . "</code></li>";
        echo "<li><strong>Alt Text:</strong> " . htmlspecialchars($config['alt_text']) . "</li>";
        echo "<li><strong>Site Title:</strong> " . htmlspecialchars($config['site_title']) . "</li>";
        echo "</ul>";
        
        // Tester si le fichier existe
        if (strpos($config['logo_path'], '/storage/') === 0) {
            $filePath = __DIR__ . '/../eclatBack/back_office/public' . $config['logo_path'];
            echo "<li><strong>Chemin fichier:</strong> <code>$filePath</code></li>";
            
            if (file_exists($filePath)) {
                echo "<p style='color: green;'>✓ Fichier image trouvé sur le serveur</p>";
                echo "<img src='" . htmlspecialchars($config['logo_path']) . "' style='max-width: 200px; border: 1px solid #ccc;'>";
            } else {
                echo "<p style='color: red;'>✗ Fichier image NON trouvé</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Aucune configuration dans la base</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Erreur DB: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";

// Test 2: Appel API direct depuis JavaScript (côté client)
echo "<h3>Test 2: Appel API (JavaScript)</h3>";
echo "<div id='api-test-result'></div>";
?>

<script>
fetch('http://localhost:8000/api/v1/config')
    .then(response => {
        console.log('HTTP Status:', response.status);
        return response.json();
    })
    .then(data => {
        const resultDiv = document.getElementById('api-test-result');
        let html = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        
        if (data.success && data.data) {
            html += '<p style="color: green;">✓ API fonctionne correctement</p>';
            
            if (data.data.logo_path) {
                html += '<p><strong>Logo Path:</strong> <code>' + data.data.logo_path + '</code></p>';
                
                // Essayer d'afficher l'image
                const imgUrl = data.data.logo_path.startsWith('http') 
                    ? data.data.logo_path 
                    : 'http://localhost:8000' + data.data.logo_path;
                
                html += '<img src="' + imgUrl + '" style="max-width: 200px; border: 1px solid #ccc;">';
            }
        } else {
            html += '<p style="color: red;">✗ API ne retourne pas de données valides</p>';
        }
        
        resultDiv.innerHTML = html;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('api-test-result').innerHTML = 
            '<p style="color: red;">✗ Erreur: ' + error.message + '</p>';
    });
</script>

<?php

echo "<hr>";

// Test 3: Test avec les fonctions helper
echo "<h3>Test 3: Fonctions Helper PHP</h3>";
require_once __DIR__ . '/config.php';

$siteTitle = getSiteTitle('Test');
$logoUrl = getLogoUrl();
$logoAlt = getLogoAlt();

echo "<ul>";
echo "<li><strong>Site Title:</strong> " . htmlspecialchars($siteTitle) . "</li>";
echo "<li><strong>Logo URL:</strong> <code>" . htmlspecialchars($logoUrl) . "</code></li>";
echo "<li><strong>Logo Alt:</strong> " . htmlspecialchars($logoAlt) . "</li>";
echo "</ul>";

// Vérifier si c'est une URL absolue ou relative
if (strpos($logoUrl, 'http') === 0) {
    echo "<p>✓ URL absolue</p>";
} else if (strpos($logoUrl, '/storage') === 0) {
    echo "<p>✓ Chemin relatif /storage/</p>";
    echo "<p>URL complète reconstruite: <code>http://localhost:8000" . htmlspecialchars($logoUrl) . "</code></p>";
} else {
    echo "<p>⚠ Chemin relatif standard</p>";
}

// Tenter d'afficher le logo
echo "<h4>Affichage du logo :</h4>";
echo "<img src='" . htmlspecialchars($logoUrl) . "' alt='" . htmlspecialchars($logoAlt) . "' style='max-width: 300px; border: 1px solid #ccc;'>";

echo "<hr>";

// Test 4: Simulation head.php
echo "<h3>Test 4: Simulation head.php</h3>";
echo "<p>Voici comment le logo sera affiché dans head.php :</p>";
echo '<link href="' . htmlspecialchars($logoUrl) . '" rel="icon">';
echo "<br><br>";
echo "<img src='" . htmlspecialchars($logoUrl) . "' rel='icon' style='max-width: 50px; border: 1px solid #ccc;'>";

?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
    h3 { color: #666; margin-top: 30px; }
    h4 { color: #999; }
    code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; }
    pre { background: #f9f9f9; padding: 15px; border-radius: 5px; overflow-x: auto; }
    p { margin: 10px 0; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
</style>

</body>
</html>
