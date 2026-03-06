<?php
// Test d'affichage du logo - Debug complet
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';

echo "<h2>🔍 Test d'affichage du Logo</h2>";
echo "<hr>";

// Récupérer les données brutes
$config = getSiteConfig();
echo "<h3>1. Données brutes de l'API :</h3>";
echo "<pre>" . print_r($config, true) . "</pre>";

echo "<h3>2. Fonctions helper :</h3>";
$siteTitle = getSiteTitle();
$logoUrl = getLogoUrl();
$logoAlt = getLogoAlt();

echo "<ul>";
echo "<li><strong>Site Title:</strong> " . htmlspecialchars($siteTitle) . "</li>";
echo "<li><strong>Logo URL:</strong> <code>" . htmlspecialchars($logoUrl) . "</code></li>";
echo "<li><strong>Logo Alt:</strong> " . htmlspecialchars($logoAlt) . "</li>";
echo "</ul>";

echo "<h3>3. Vérification du type d'URL :</h3>";
if (strpos($logoUrl, 'http') === 0) {
    echo "<p style='color: green;'>✓ URL absolue détectée</p>";
} else if (strpos($logoUrl, '/storage') === 0) {
    echo "<p style='color: orange;'>⚠ Chemin /storage/ détecté (sera converti)</p>";
} else {
    echo "<p style='color: blue;'>ℹ️ Chemin relatif local</p>";
}

echo "<h3>4. Test d'affichage direct :</h3>";
echo "<div style='border: 2px solid #333; padding: 20px; margin: 20px 0; background: #f9f9f9;'>";
echo "<h4>Logo avec getLogoUrl() :</h4>";
echo "<img src='" . htmlspecialchars($logoUrl) . "' alt='" . htmlspecialchars($logoAlt) . "' style='max-width: 300px; border: 1px solid #ccc; display: block; margin: 10px 0;'>";
echo "</div>";

// Tester différentes variantes d'URL
echo "<h3>5. Test des variantes d'URL :</h3>";
echo "<ul>";

// Variante 1: URL directe depuis config
echo "<li><strong>Depuis config['logo_path']:</strong> ";
echo "<code>" . htmlspecialchars($config['logo_path']) . "</code><br>";
if (!empty($config['logo_path'])) {
    echo "<img src='" . htmlspecialchars($config['logo_path']) . "' style='max-width: 100px; border: 1px solid red;'>";
}
echo "</li>";

// Variante 2: Avec localhost:8000
if (strpos($config['logo_path'], '/storage') === 0) {
    echo "<li><strong>Avec http://localhost:8000:</strong> ";
    $testUrl = 'http://localhost:8000' . $config['logo_path'];
    echo "<code>$testUrl</code><br>";
    echo "<img src='$testUrl' style='max-width: 100px; border: 1px solid blue;'>";
    echo "</li>";
}

// Variante 3: Avec host.docker.internal
if (strpos($config['logo_path'], '/storage') === 0) {
    echo "<li><strong>Avec http://host.docker.internal:8000:</strong> ";
    $testUrl = 'http://host.docker.internal:8000' . $config['logo_path'];
    echo "<code>$testUrl</code><br>";
    echo "<img src='$testUrl' style='max-width: 100px; border: 1px solid green;'>";
    echo "</li>";
}

echo "</ul>";

echo "<h3>6. Simulation head.php :</h3>";
echo "<p>Voici comment le favicon sera affiché dans head.php :</p>";
echo "<code>&lt;link href=\"&lt;?php echo htmlspecialchars(\$logoUrl); ?&gt;\" rel=\"icon\"&gt;</code>";
echo "<br><br>";
echo "Résultat : <link href='" . htmlspecialchars($logoUrl) . "' rel='icon'>";
echo "<br><br>";
echo "<img src='" . htmlspecialchars($logoUrl) . "' style='max-width: 50px; border: 1px solid #333;'>";

echo "<h3>7. Informations API :</h3>";
global $apiBaseUrl;
echo "<p><strong>API Base URL:</strong> <code>$apiBaseUrl</code></p>";

// Tester la connexion API
$ch = curl_init($apiBaseUrl . '/v1/config');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>Code HTTP API:</strong> $httpCode</p>";
if ($httpCode === 200) {
    echo "<p style='color: green;'>✓ API accessible</p>";
} else {
    echo "<p style='color: red;'>✗ API non accessible</p>";
}

?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
    h3 { color: #666; margin-top: 30px; }
    h4 { color: #999; }
    code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; color: #e74c3c; }
    pre { background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 5px; overflow-x: auto; }
    p { margin: 10px 0; line-height: 1.6; }
    ul { margin: 10px 0; padding-left: 30px; }
    li { margin: 5px 0; }
    img { margin: 10px 0; }
</style>

</body>
</html>
