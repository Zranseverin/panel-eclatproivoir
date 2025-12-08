<?php
echo "<h2>Demo: CRUD Operations - Add, Modify, Delete Logos</h2>\n";

function callApi($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    if ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return array(
        'code' => $httpCode,
        'response' => $response ? json_decode($response, true) : null
    );
}

// Step 1: Get all logos initially
echo "<h3>Step 1: Initial State - Get All Logos</h3>\n";
$result = callApi('http://localhost/ivoirPro/api/get_all_logos.php');
echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
if ($result['code'] == 200 && $result['response']) {
    echo "<p>Found " . count($result['response']) . " logo(s):</p>\n";
    echo "<ul>\n";
    foreach ($result['response'] as $logo) {
        echo "<li>ID: " . $logo['id'] . " - " . htmlspecialchars($logo['alt_text']) . "</li>\n";
    }
    echo "</ul>\n";
} else {
    echo "<p>No logos found or error occurred</p>\n";
}

// Step 2: Add a new logo
echo "<h3>Step 2: Add a New Logo</h3>\n";
$newLogoData = array(
    'logo_path' => 'http://127.0.0.1:8000/storage/logos/new-demo-logo.png',
    'alt_text' => 'Demo New Logo'
);

$result = callApi('http://localhost/ivoirPro/api/create_logo.php', 'POST', $newLogoData);
echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
if ($result['code'] == 201 && $result['response']) {
    $newLogoId = $result['response']['id'];
    echo "<p>✅ New logo created with ID: " . $newLogoId . "</p>\n";
} else {
    echo "<p>❌ Failed to create new logo</p>\n";
    $newLogoId = null;
}

// Step 3: Get all logos after adding
echo "<h3>Step 3: Get All Logos After Adding</h3>\n";
$result = callApi('http://localhost/ivoirPro/api/get_all_logos.php');
echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
if ($result['code'] == 200 && $result['response']) {
    echo "<p>Found " . count($result['response']) . " logo(s):</p>\n";
    echo "<ul>\n";
    foreach ($result['response'] as $logo) {
        echo "<li>ID: " . $logo['id'] . " - " . htmlspecialchars($logo['alt_text']) . "</li>\n";
    }
    echo "</ul>\n";
}

// Step 4: Modify the new logo
echo "<h3>Step 4: Modify the New Logo</h3>\n";
if ($newLogoId) {
    $updateData = array(
        'id' => $newLogoId,
        'logo_path' => 'http://127.0.0.1:8000/storage/logos/modified-demo-logo.png',
        'alt_text' => 'Demo Modified Logo'
    );
    
    $result = callApi('http://localhost/ivoirPro/api/update_logo.php', 'PUT', $updateData);
    echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
    if ($result['code'] == 200 && $result['response']) {
        echo "<p>✅ Logo modified successfully</p>\n";
    } else {
        echo "<p>❌ Failed to modify logo</p>\n";
    }
}

// Step 5: Get all logos after modifying
echo "<h3>Step 5: Get All Logos After Modifying</h3>\n";
$result = callApi('http://localhost/ivoirPro/api/get_all_logos.php');
echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
if ($result['code'] == 200 && $result['response']) {
    echo "<p>Found " . count($result['response']) . " logo(s):</p>\n";
    echo "<ul>\n";
    foreach ($result['response'] as $logo) {
        echo "<li>ID: " . $logo['id'] . " - " . htmlspecialchars($logo['alt_text']) . " - " . htmlspecialchars($logo['logo_path']) . "</li>\n";
    }
    echo "</ul>\n";
}

// Step 6: Delete the new logo
echo "<h3>Step 6: Delete the New Logo</h3>\n";
if ($newLogoId) {
    $deleteData = array('id' => $newLogoId);
    
    $result = callApi('http://localhost/ivoirPro/api/delete_logo.php', 'DELETE', $deleteData);
    echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
    if ($result['code'] == 200 && $result['response']) {
        echo "<p>✅ Logo deleted successfully</p>\n";
    } else {
        echo "<p>❌ Failed to delete logo</p>\n";
    }
}

// Step 7: Get all logos after deleting
echo "<h3>Step 7: Get All Logos After Deleting</h3>\n";
$result = callApi('http://localhost/ivoirPro/api/get_all_logos.php');
echo "<p>HTTP Status: " . $result['code'] . "</p>\n";
if ($result['code'] == 200 && $result['response']) {
    echo "<p>Found " . count($result['response']) . " logo(s):</p>\n";
    echo "<ul>\n";
    foreach ($result['response'] as $logo) {
        echo "<li>ID: " . $logo['id'] . " - " . htmlspecialchars($logo['alt_text']) . "</li>\n";
    }
    echo "</ul>\n";
} elseif ($result['code'] == 404) {
    echo "<p>No logos found (all deleted)</p>\n";
}

echo "<h3>Conclusion</h3>\n";
echo "<p>The API now supports full CRUD operations:</p>\n";
echo "<ul>\n";
echo "<li><strong>CREATE</strong>: Add new logos with POST to <code>/api/create_logo.php</code></li>\n";
echo "<li><strong>READ</strong>: Get all logos with GET to <code>/api/get_all_logos.php</code></li>\n";
echo "<li><strong>UPDATE</strong>: Modify existing logos with PUT to <code>/api/update_logo.php</code></li>\n";
echo "<li><strong>DELETE</strong>: Remove logos with DELETE to <code>/api/delete_logo.php</code></li>\n";
echo "</ul>\n";
echo "<p>Every operation is immediately reflected in the API responses!</p>\n";
?>