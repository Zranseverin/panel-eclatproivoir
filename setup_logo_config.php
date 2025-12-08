<?php
require_once 'classes/Database.php';

echo "Setting up logo configuration...\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Failed to connect to database\n");
    }
    
    echo "✅ Database connection successful\n";
    
    // Check if config_logo table exists
    try {
        $stmt = $conn->prepare("SHOW TABLES LIKE 'config_logo'");
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            // Create the table
            echo "Creating config_logo table...\n";
            $createStmt = $conn->prepare("
                CREATE TABLE config_logo (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    logo_path VARCHAR(255) NOT NULL,
                    alt_text VARCHAR(255) DEFAULT 'Logo',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )
            ");
            $createStmt->execute();
            echo "✅ config_logo table created\n";
        } else {
            echo "✅ config_logo table exists\n";
        }
    } catch (Exception $e) {
        echo "Error checking/creating table: " . $e->getMessage() . "\n";
    }
    
    // Check if there's a record with ID 1
    $stmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        // Insert default logo configuration
        echo "Inserting default logo configuration...\n";
        $insertStmt = $conn->prepare("
            INSERT INTO config_logo (id, logo_path, alt_text) 
            VALUES (1, 'storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png', 'EclatPro Logo')
        ");
        if ($insertStmt->execute()) {
            echo "✅ Default logo configuration inserted\n";
        } else {
            echo "❌ Failed to insert default logo configuration\n";
        }
    } else {
        echo "✅ Logo configuration already exists\n";
        // Update it to make sure it has the correct values
        $updateStmt = $conn->prepare("
            UPDATE config_logo 
            SET logo_path = 'storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png', 
                alt_text = 'EclatPro Logo'
            WHERE id = 1
        ");
        if ($updateStmt->execute()) {
            echo "✅ Logo configuration updated\n";
        } else {
            echo "❌ Failed to update logo configuration\n";
        }
    }
    
    echo "\nSetup complete! Try accessing http://localhost/ivoirPro/api/get_logo_config.php again.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>