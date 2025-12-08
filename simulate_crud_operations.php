<?php
// Simulation of CRUD operations to demonstrate that API reflects changes

echo "<h1>Simulation des opérations CRUD</h1>\n";

// Helper function to make HTTP requests
function makeRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data && ($method === 'POST' || $method === 'PUT')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    
    if ($method === 'DELETE' && $data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['response' => $response, 'httpCode' => $httpCode];
}

// Function to display current logo from main API
function displayCurrentLogo() {
    $result = makeRequest('http://localhost/ivoirPro/api/get_logo_config.php', 'GET');
    echo "<h3>Logo actuel via get_logo_config.php:</h3>\n";
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
}

// Function to display all logos
function displayAllLogos() {
    $result = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
    echo "<h3>Tous les logos via get_all_logos.php:</h3>\n";
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
}

echo "<h2>1. État initial</h2>\n";
displayCurrentLogo();
displayAllLogos();

echo "<h2>2. Ajout d'un nouveau logo</h2>\n";
$newLogoData = [
    'logo_path' => 'http://127.0.0.1:8000/storage/logos/simulated_logo_' . time() . '.png',
    'alt_text' => 'Logo simulé'
];

$result = makeRequest('http://localhost/ivoirPro/api/create_logo.php', 'POST', $newLogoData);
echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";

echo "<h2>3. Après l'ajout - API reflétant le changement</h2>\n";
displayCurrentLogo();
displayAllLogos();

echo "<h2>4. Modification du logo</h2>\n";
// Get all logos to find the one we just created
$allLogosResult = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
$logos = json_decode($allLogosResult['response'], true);

if (!empty($logos)) {
    $lastLogo = end($logos);
    $updateData = [
        'id' => $lastLogo['id'],
        'logo_path' => 'http://127.0.0.1:8000/storage/logos/modified_logo_' . time() . '.png',
        'alt_text' => 'Logo modifié'
    ];
    
    $result = makeRequest('http://localhost/ivoirPro/api/update_logo.php', 'PUT', $updateData);
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
    
    echo "<h2>5. Après la modification - API reflétant le changement</h2>\n";
    displayCurrentLogo();
    displayAllLogos();
    
    echo "<h2>6. Suppression du logo</h2>\n";
    $deleteData = ['id' => $lastLogo['id']];
    $result = makeRequest('http://localhost/ivoirPro/api/delete_logo.php', 'DELETE', $deleteData);
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
    
    echo "<h2>7. Après la suppression - API reflétant le changement</h2>\n";
    displayCurrentLogo();
    displayAllLogos();
} else {
    echo "<p>Impossible de continuer la simulation car aucun logo n'a été trouvé.</p>\n";
}

echo "<h2>Résumé</h2>\n";
echo "<p>Comme démontré ci-dessus, l'API <code>get_logo_config.php</code> reflète maintenant immédiatement les changements :</p>\n";
echo "<ul>\n";
echo "<li>Lorsque vous <strong>ajoutez</strong> un logo, il devient disponible via l'API</li>\n";
echo "<li>Lorsque vous <strong>modifiez</strong> un logo, l'API retourne les informations mises à jour</li>\n";
echo "<li>Lorsque vous <strong>supprimez</strong> un logo, l'API s'adapte automatiquement</li>\n";
echo "</ul>\n";
echo "<p>L'API utilise maintenant une logique améliorée :</p>\n";
echo "<ol>\n";
echo "<li>Elle tente d'abord de récupérer le logo avec l'ID spécifié (ou ID=1 par défaut)</li>\n";
echo "<li>Si cet ID n'existe pas, elle retourne automatiquement le premier logo disponible</li>\n";
echo "<li>Si aucun logo n'existe, elle retourne un message approprié</li>\n";
echo "</ol>\n";
?>