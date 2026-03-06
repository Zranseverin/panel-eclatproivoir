<?php
// Test API endpoint
$apiUrl = 'http://host.docker.internal:8000/api/v1/navbar-brand';

echo "<h2>Testing Navbar Brand API</h2>";
echo "<p><strong>API URL:</strong> {$apiUrl}</p>";

try {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "<p><strong>HTTP Code:</strong> {$httpCode}</p>";
    
    if ($error) {
        echo "<p style='color: red;'><strong>cURL Error:</strong> {$error}</p>";
    }
    
    if ($response) {
        $data = json_decode($response, true);
        echo "<h3>API Response:</h3>";
        echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT) . "</pre>";
        
        if (isset($data['success']) && $data['success'] && isset($data['data'])) {
            echo "<h3>Parsed Data:</h3>";
            echo "<ul>";
            foreach ($data['data'] as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            echo "</ul>";
            
            echo "<h3>Logo Test:</h3>";
            $logoPath = $data['data']['logo_path'];
            echo "<p><strong>Logo Path from API:</strong> <a href='{$logoPath}' target='_blank'>{$logoPath}</a></p>";
            echo "<p><strong>Logo Image:</strong></p>";
            echo "<img src='{$logoPath}' alt='Logo' style='max-width: 300px; border: 2px solid green;'>";
        } else {
            echo "<p style='color: orange;'><strong>Warning:</strong> API returned unsuccessful response</p>";
        }
    } else {
        echo "<p style='color: red;'><strong>Error:</strong> Empty response from API</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Exception:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Direct File Access Test:</h3>";
$directPath = 'http://localhost:8000/storage/navbar_brands/1772569964_fonda.png';
echo "<p><strong>Direct Path:</strong> <a href='{$directPath}' target='_blank'>{$directPath}</a></p>";
echo "<img src='{$directPath}' alt='Direct Logo' style='max-width: 300px; border: 2px solid blue;'>";
?>
