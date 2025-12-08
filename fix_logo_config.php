<?php
require_once 'classes/Database.php';

echo "<h2>Fix Logo Configuration</h2>\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "<p>✅ Database connection successful</p>\n";
        
        // Check if config_logo table exists
        $stmt = $conn->prepare("SHOW TABLES LIKE 'config_logo'");
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo "<p>✅ config_logo table exists</p>\n";
            
            // Check if there's a record with ID 1
            $stmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p>✅ Logo configuration found (ID: " . $row['id'] . ")</p>\n";
                echo "<ul>\n";
                echo "<li>Logo Path: " . htmlspecialchars($row['logo_path']) . "</li>\n";
                echo "<li>Alt Text: " . htmlspecialchars($row['alt_text']) . "</li>\n";
                echo "<li>Created At: " . htmlspecialchars($row['created_at']) . "</li>\n";
                echo "<li>Updated At: " . htmlspecialchars($row['updated_at']) . "</li>\n";
                echo "</ul>\n";
            } else {
                echo "<p>❌ No logo configuration found with ID 1</p>\n";
                
                // Check all records in the table
                $stmt = $conn->prepare("SELECT * FROM config_logo");
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo "<p>Other records in config_logo table:</p>\n";
                    echo "<ul>\n";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>ID: " . $row['id'] . " - Path: " . htmlspecialchars($row['logo_path']) . "</li>\n";
                    }
                    echo "</ul>\n";
                } else {
                    echo "<p>❌ config_logo table is empty</p>\n";
                }
                
                // Insert a default record
                echo "<h3>Inserting default logo configuration...</h3>\n";
                $insertStmt = $conn->prepare("INSERT INTO config_logo (id, logo_path, alt_text, created_at, updated_at) VALUES (1, 'storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png', 'EclatPro Logo', NOW(), NOW())");
                if ($insertStmt->execute()) {
                    echo "<p>✅ Default logo configuration inserted</p>\n";
                } else {
                    echo "<p>❌ Failed to insert default logo configuration</p>\n";
                }
            }
        } else {
            echo "<p>❌ config_logo table does not exist</p>\n";
            
            // Create the table
            echo "<h3>Creating config_logo table...</h3>\n";
            $createTableStmt = $conn->prepare("
                CREATE TABLE config_logo (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    logo_path VARCHAR(255) NOT NULL,
                    alt_text VARCHAR(255) DEFAULT 'Logo',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )
            ");
            if ($createTableStmt->execute()) {
                echo "<p>✅ config_logo table created</p>\n";
                
                // Insert a default record
                echo "<h3>Inserting default logo configuration...</h3>\n";
                $insertStmt = $conn->prepare("INSERT INTO config_logo (id, logo_path, alt_text, created_at, updated_at) VALUES (1, 'storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png', 'EclatPro Logo', NOW(), NOW())");
                if ($insertStmt->execute()) {
                    echo "<p>✅ Default logo configuration inserted</p>\n";
                } else {
                    echo "<p>❌ Failed to insert default logo configuration</p>\n";
                }
            } else {
                echo "<p>❌ Failed to create config_logo table</p>\n";
            }
        }
    } else {
        echo "<p>❌ Database connection failed</p>\n";
    }
} catch (Exception $e) {
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

echo "<h3>Testing API after fix:</h3>\n";

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