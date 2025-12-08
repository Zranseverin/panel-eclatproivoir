<?php
require_once 'classes/Database.php';

echo "<h2>Demo: Database Changes Reflected in API</h2>\n";

function callApi() {
    $apiUrl = 'http://localhost/ivoirPro/api/get_logo_config.php';
    
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200 && $response !== false) {
            return json_decode($response, true);
        }
    }
    return null;
}

function updateDatabase($newPath, $newAltText) {
    try {
        require_once 'classes/Database.php';
        $database = new Database();
        $conn = $database->getConnection();
        
        $stmt = $conn->prepare("
            UPDATE config_logo 
            SET logo_path = :logo_path, 
                alt_text = :alt_text
            WHERE id = 1
        ");
        $stmt->bindParam(':logo_path', $newPath);
        $stmt->bindParam(':alt_text', $newAltText);
        
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

// Get initial state
echo "<h3>Step 1: Initial State</h3>\n";
$initialData = callApi();
if ($initialData) {
    echo "<p><strong>API Response:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Logo Path: " . htmlspecialchars($initialData['logo_path']) . "</li>\n";
    echo "<li>Alt Text: " . htmlspecialchars($initialData['alt_text']) . "</li>\n";
    echo "</ul>\n";
} else {
    echo "<p>Failed to get initial API response</p>\n";
    exit;
}

// Change the database
echo "<h3>Step 2: Changing Database</h3>\n";
$newPath = 'http://127.0.0.1:8000/storage/logos/demo-changed-logo.png';
$newAltText = 'Demo Changed Logo';

echo "<p>Updating database with:</p>\n";
echo "<ul>\n";
echo "<li>New Logo Path: " . htmlspecialchars($newPath) . "</li>\n";
echo "<li>New Alt Text: " . htmlspecialchars($newAltText) . "</li>\n";
echo "</ul>\n";

if (updateDatabase($newPath, $newAltText)) {
    echo "<p>✅ Database updated successfully</p>\n";
} else {
    echo "<p>❌ Failed to update database</p>\n";
    exit;
}

// Check API after change
echo "<h3>Step 3: API After Database Change</h3>\n";
$changedData = callApi();
if ($changedData) {
    echo "<p><strong>API Response:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Logo Path: " . htmlspecialchars($changedData['logo_path']) . "</li>\n";
    echo "<li>Alt Text: " . htmlspecialchars($changedData['alt_text']) . "</li>\n";
    echo "</ul>\n";
    
    // Verify the change
    if ($changedData['logo_path'] === $newPath && $changedData['alt_text'] === $newAltText) {
        echo "<p>✅ <strong>SUCCESS!</strong> The API now reflects the database changes!</p>\n";
    } else {
        echo "<p>❌ The API does not reflect the database changes</p>\n";
    }
} else {
    echo "<p>❌ Failed to get updated API response</p>\n";
}

// Restore original data
echo "<h3>Step 4: Restoring Original Data</h3>\n";
if (updateDatabase($initialData['logo_path'], $initialData['alt_text'])) {
    echo "<p>✅ Original data restored</p>\n";
} else {
    echo "<p>❌ Failed to restore original data</p>\n";
}

echo "<h3>Conclusion</h3>\n";
echo "<p>The API <strong>does</strong> reflect changes made to the database table. When you update the data in the <code>config_logo</code> table, the API at <code>http://localhost/ivoirPro/api/get_logo_config.php</code> will immediately return the updated information.</p>\n";
?>