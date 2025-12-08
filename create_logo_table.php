<?php
require_once 'classes/Database.php';

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    try {
        // Create the config_logo table
        $sql = "
        CREATE TABLE IF NOT EXISTS config_logo (
            id INT AUTO_INCREMENT PRIMARY KEY,
            logo_path VARCHAR(255) NOT NULL,
            alt_text VARCHAR(255) DEFAULT 'Logo',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $conn->exec($sql);
        echo "config_logo table created successfully\n";
        
        // Insert default logo configuration
        $insertSql = "INSERT IGNORE INTO config_logo (id, logo_path, alt_text) VALUES (1, 'img/logo.jpg', 'EclatPro Logo')";
        $conn->exec($insertSql);
        echo "Default logo configuration inserted\n";
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "Database connection failed\n";
}
?>