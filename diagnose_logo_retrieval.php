<?php
require_once 'classes/Database.php';
require_once 'classes/LogoConfig.php';

echo "<h2>Diagnose Logo Retrieval</h2>\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("<p>❌ Failed to connect to database</p>\n");
    }
    
    echo "<p>✅ Database connection successful</p>\n";
    
    // Check if config_logo table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'config_logo'");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        echo "<p>❌ config_logo table does not exist</p>\n";
        exit;
    } else {
        echo "<p>✅ config_logo table exists</p>\n";
    }
    
    // Check all records in the table
    $stmt = $conn->prepare("SELECT * FROM config_logo");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        echo "<p>❌ config_logo table is empty</p>\n";
    } else {
        echo "<p>✅ Found " . $stmt->rowCount() . " record(s) in config_logo table:</p>\n";
        echo "<ul>\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>ID: " . $row['id'] . " - Path: " . htmlspecialchars($row['logo_path']) . " - Alt: " . htmlspecialchars($row['alt_text']) . "</li>\n";
        }
        echo "</ul>\n";
    }
    
    // Test the LogoConfig class directly
    echo "<h3>Testing LogoConfig class:</h3>\n";
    $logoConfig = new LogoConfig();
    
    if ($logoConfig->getLogo()) {
        echo "<p>✅ LogoConfig->getLogo() returned true</p>\n";
        echo "<ul>\n";
        echo "<li>ID: " . htmlspecialchars($logoConfig->id) . "</li>\n";
        echo "<li>Logo Path: " . htmlspecialchars($logoConfig->logo_path) . "</li>\n";
        echo "<li>Alt Text: " . htmlspecialchars($logoConfig->alt_text) . "</li>\n";
        echo "<li>Created At: " . htmlspecialchars($logoConfig->created_at) . "</li>\n";
        echo "<li>Updated At: " . htmlspecialchars($logoConfig->updated_at) . "</li>\n";
        echo "</ul>\n";
    } else {
        echo "<p>❌ LogoConfig->getLogo() returned false</p>\n";
        
        // Check specifically for ID = 1
        $stmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo "<p>✅ Record with ID = 1 exists in database</p>\n";
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<ul>\n";
            echo "<li>ID: " . $row['id'] . "</li>\n";
            echo "<li>Logo Path: " . htmlspecialchars($row['logo_path']) . "</li>\n";
            echo "<li>Alt Text: " . htmlspecialchars($row['alt_text']) . "</li>\n";
            echo "</ul>\n";
            
            echo "<p>Possible issue: LogoConfig class query might be different</p>\n";
        } else {
            echo "<p>❌ No record with ID = 1 in database</p>\n";
        }
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

echo "<h3>Testing API directly:</h3>\n";

// Test the API
$apiUrl = 'http://localhost/ivoirPro/api/get_logo_config.php';
echo "<p>API URL: <a href='" . htmlspecialchars($apiUrl) . "' target='_blank'>" . htmlspecialchars($apiUrl) . "</a></p>\n";

if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<p>HTTP Status: " . $httpCode . "</p>\n";
    if ($response !== false) {
        echo "<p>API Response:</p>\n";
        echo "<pre>" . htmlspecialchars($response) . "</pre>\n";
    }
}
?>