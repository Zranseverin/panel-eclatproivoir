<?php
require_once 'classes/Database.php';

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // First, let's check if there's already a record with ID 1
    $checkQuery = "SELECT id FROM config_logo WHERE id = 1";
    $stmt = $conn->prepare($checkQuery);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Update existing record
        $updateQuery = "UPDATE config_logo SET 
                        logo_path = :logo_path, 
                        alt_text = :alt_text,
                        updated_at = NOW()
                        WHERE id = 1";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':logo_path', $logoPath);
        $stmt->bindParam(':alt_text', $altText);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO config_logo (id, logo_path, alt_text, created_at, updated_at) 
                        VALUES (1, :logo_path, :alt_text, NOW(), NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':logo_path', $logoPath);
        $stmt->bindParam(':alt_text', $altText);
    }
    
    // Use the actual logo file we found
    $logoPath = 'storage/logos/iZABrj5awcNfNW5bj8pKHJ65hofQcSUfx1ho0iWh.png';
    $altText = 'EclatPro Logo';
    
    if ($stmt->execute()) {
        echo "Logo configuration saved successfully!\n";
        echo "Logo path: " . $logoPath . "\n";
        echo "Alt text: " . $altText . "\n";
    } else {
        echo "Failed to save logo configuration.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>