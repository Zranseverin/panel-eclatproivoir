<?php
require_once 'classes/Database.php';

echo "Fixing logo configuration ID...\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Failed to connect to database\n");
    }
    
    echo "✅ Database connection successful\n";
    
    // Check if there's a record with ID = 1
    $checkStmt = $conn->prepare("SELECT id FROM config_logo WHERE id = 1");
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() > 0) {
        echo "✅ Record with ID = 1 already exists\n";
    } else {
        echo "❌ No record with ID = 1 found\n";
        
        // Check if there's a record with ID = 6
        $checkStmt2 = $conn->prepare("SELECT * FROM config_logo WHERE id = 6");
        $checkStmt2->execute();
        
        if ($checkStmt2->rowCount() > 0) {
            $row = $checkStmt2->fetch(PDO::FETCH_ASSOC);
            echo "✅ Found record with ID = 6\n";
            
            // Update it to have ID = 1
            echo "Updating record ID from 6 to 1...\n";
            $updateStmt = $conn->prepare("
                UPDATE config_logo 
                SET id = 1,
                    logo_path = :logo_path,
                    alt_text = :alt_text
                WHERE id = 6
            ");
            $updateStmt->bindParam(':logo_path', $row['logo_path']);
            $updateStmt->bindParam(':alt_text', $row['alt_text']);
            
            if ($updateStmt->execute()) {
                echo "✅ Record updated successfully\n";
            } else {
                echo "❌ Failed to update record\n";
            }
        } else {
            echo "❌ No record with ID = 6 found either\n";
            
            // Insert a default record with ID = 1
            echo "Inserting default record with ID = 1...\n";
            $insertStmt = $conn->prepare("
                INSERT INTO config_logo (id, logo_path, alt_text) 
                VALUES (1, 'http://127.0.0.1:8000/storage/logos/otrcyA9RendLm1mvaxPJAqcibf8q4ORrF98O8UoJ.png', 'Logo')
            ");
            
            if ($insertStmt->execute()) {
                echo "✅ Default record inserted successfully\n";
            } else {
                echo "❌ Failed to insert default record\n";
            }
        }
    }
    
    echo "\nVerification:\n";
    $verifyStmt = $conn->prepare("SELECT * FROM config_logo WHERE id = 1");
    $verifyStmt->execute();
    
    if ($verifyStmt->rowCount() > 0) {
        $row = $verifyStmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Record with ID = 1:\n";
        echo "- ID: " . $row['id'] . "\n";
        echo "- Logo Path: " . $row['logo_path'] . "\n";
        echo "- Alt Text: " . $row['alt_text'] . "\n";
    } else {
        echo "❌ Still no record with ID = 1\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>