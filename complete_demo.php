<?php
// Complete demonstration of CRUD operations with immediate API reflection
echo "<h1>Démonstration complète du système CRUD avec API</h1>\n";
echo "<p>Cette démonstration montre que l'API reflète immédiatement les changements dans la base de données.</p>\n";

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

// 1. Show current state of all logos
echo "<h2>1. État actuel de tous les logos :</h2>\n";
$result = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";

// 2. Add a new logo
echo "<h2>2. Ajout d'un nouveau logo :</h2>\n";
$newLogoData = [
    'logo_path' => 'http://127.0.0.1:8000/storage/logos/new_logo_' . time() . '.png',
    'alt_text' => 'Nouveau Logo'
];

$result = makeRequest('http://localhost/ivoirPro/api/create_logo.php', 'POST', $newLogoData);
echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";

// Extract the ID of the newly created logo for later operations
$responseData = json_decode($result['response'], true);
$newLogoId = isset($responseData['id']) ? $responseData['id'] : null;

// 3. Show updated state after adding
echo "<h2>3. État après ajout (API reflétant immédiatement le changement) :</h2>\n";
$result = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";

// 4. Modify the newly added logo (if creation was successful)
if ($newLogoId) {
    echo "<h2>4. Modification du logo nouvellement créé :</h2>\n";
    $updateData = [
        'id' => $newLogoId,
        'logo_path' => 'http://127.0.0.1:8000/storage/logos/updated_logo_' . time() . '.png',
        'alt_text' => 'Logo Mis à Jour'
    ];
    
    $result = makeRequest('http://localhost/ivoirPro/api/update_logo.php', 'PUT', $updateData);
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
    
    // 5. Show updated state after modification
    echo "<h2>5. État après modification (API reflétant immédiatement le changement) :</h2>\n";
    $result = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
    
    // 6. Delete the logo
    echo "<h2>6. Suppression du logo :</h2>\n";
    $deleteData = ['id' => $newLogoId];
    $result = makeRequest('http://localhost/ivoirPro/api/delete_logo.php', 'DELETE', $deleteData);
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
    
    // 7. Show final state after deletion
    echo "<h2>7. État final après suppression (API reflétant immédiatement le changement) :</h2>\n";
    $result = makeRequest('http://localhost/ivoirPro/api/get_all_logos.php', 'GET');
    echo "<pre>" . htmlspecialchars($result['response']) . "</pre>\n";
    echo "<p>Code HTTP : " . $result['httpCode'] . "</p>\n";
} else {
    echo "<p>Impossible de continuer la démonstration car la création du logo a échoué.</p>\n";
}

echo "<h2>Résumé :</h2>\n";
echo "<p>Comme vous pouvez le voir, chaque opération (ajout, modification, suppression) est immédiatement reflétée par l'API. Cela fonctionne parce que :</p>\n";
echo "<ol>\n";
echo "<li>L'API interroge directement la base de données à chaque requête</li>\n";
echo "<li>Il n'y a pas de mise en cache qui empêcherait la mise à jour immédiate</li>\n";
echo "<li>Chaque endpoint effectue des opérations directes sur la base de données</li>\n";
echo "</ol>\n";
echo "<p>Pour utiliser ces API dans votre application :</p>\n";
echo "<ul>\n";
echo "<li>GET http://localhost/ivoirPro/api/get_all_logos.php - Récupère tous les logos</li>\n";
echo "<li>POST http://localhost/ivoirPro/api/create_logo.php - Crée un nouveau logo</li>\n";
echo "<li>PUT http://localhost/ivoirPro/api/update_logo.php - Met à jour un logo existant</li>\n";
echo "<li>DELETE http://localhost/ivoirPro/api/delete_logo.php - Supprime un logo (avec ID dans le corps)</li>\n";
echo "</ul>\n";
?>