<?php
require_once 'classes/Database.php';

echo "Checking all logo records in the database...\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Failed to connect to database\n");
    }
    
    echo "✅ Database connection successful\n";
    
    // Check if config_logo table exists
    $stmt = $conn->prepare("SHOW TABLES LIKE 'config_logo'");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        echo "❌ config_logo table does not exist\n";
        exit;
    } else {
        echo "✅ config_logo table exists\n";
    }
    
    // Get all records in the table
    echo "\nGetting all records from config_logo table:\n";
    $stmt = $conn->prepare("SELECT * FROM config_logo ORDER BY id");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        echo "❌ config_logo table is empty\n";
    } else {
        echo "Found " . $stmt->rowCount() . " record(s):\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "----------------------------------------\n";
            echo "ID: " . $row['id'] . "\n";
            echo "Logo Path: " . $row['logo_path'] . "\n";
            echo "Alt Text: " . $row['alt_text'] . "\n";
            echo "Created At: " . $row['created_at'] . "\n";
            echo "Updated At: " . $row['updated_at'] . "\n";
            echo "----------------------------------------\n";
        }
    }
    
    // Specifically check for ID = 1
    echo "\nChecking specifically for ID = 1:\n";
    $stmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Record with ID = 1 found:\n";
        echo "- ID: " . $row['id'] . "\n";
        echo "- Logo Path: " . $row['logo_path'] . "\n";
        echo "- Alt Text: " . $row['alt_text'] . "\n";
        echo "- Created At: " . $row['created_at'] . "\n";
        echo "- Updated At: " . $row['updated_at'] . "\n";
    } else {
        echo "❌ No record with ID = 1 found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTesting API response:\n";
$apiUrl = 'http://localhost/ivoirPro/api/get_logo_config.php';

if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Status: " . $httpCode . "\n";
    if ($response !== false) {
        echo "API Response:\n" . $response . "\n";
    }
}
?>