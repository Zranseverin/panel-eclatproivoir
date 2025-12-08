<?php
require_once 'classes/Database.php';

echo "Simple update test...\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // Get current data
    echo "Getting current data...\n";
    $stmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
    $stmt->execute();
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Current logo path: " . $current['logo_path'] . "\n";
    echo "Current alt text: " . $current['alt_text'] . "\n";
    
    // Update the data
    echo "Updating data...\n";
    $updateStmt = $conn->prepare("
        UPDATE config_logo 
        SET logo_path = :logo_path, 
            alt_text = :alt_text
        WHERE id = 1
    ");
    $newPath = 'http://127.0.0.1:8000/storage/logos/updated-test-logo.png';
    $newAlt = 'Test Updated Logo';
    
    $updateStmt->bindParam(':logo_path', $newPath);
    $updateStmt->bindParam(':alt_text', $newAlt);
    $updateStmt->execute();
    
    echo "Data updated in database.\n";
    echo "New logo path: " . $newPath . "\n";
    echo "New alt text: " . $newAlt . "\n";
    
    // Verify the update
    echo "Verifying update...\n";
    $verifyStmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
    $verifyStmt->execute();
    $updated = $verifyStmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Verified logo path: " . $updated['logo_path'] . "\n";
    echo "Verified alt text: " . $updated['alt_text'] . "\n";
    
    if ($updated['logo_path'] === $newPath && $updated['alt_text'] === $newAlt) {
        echo "✅ Database update successful!\n";
    } else {
        echo "❌ Database update failed!\n";
    }
    
    // Restore original data
    echo "Restoring original data...\n";
    $restoreStmt = $conn->prepare("
        UPDATE config_logo 
        SET logo_path = :logo_path, 
            alt_text = :alt_text
        WHERE id = 1
    ");
    $restoreStmt->bindParam(':logo_path', $current['logo_path']);
    $restoreStmt->bindParam(':alt_text', $current['alt_text']);
    $restoreStmt->execute();
    
    echo "Original data restored.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>