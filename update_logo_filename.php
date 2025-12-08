<?php
require_once 'classes/Database.php';

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // Update the logo path with the correct file name
    $newLogoPath = 'storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png';
    
    $query = "UPDATE config_logo SET logo_path = :logo_path WHERE id = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':logo_path', $newLogoPath);
    
    if ($stmt->execute()) {
        echo "Database updated with correct file name: " . $newLogoPath . "\n";
    } else {
        echo "Failed to update database.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>