<?php
require_once 'classes/Database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->prepare("UPDATE config_logo SET logo_path = 'storage/logos/ig8T8UXXepvqppNMu64bF2JTK8UDbvpOgZraCyIA.png' WHERE id = 1");
    $stmt->execute();
    
    echo "Database updated successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>