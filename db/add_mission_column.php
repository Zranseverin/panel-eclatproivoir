<?php
// Script to add mission column to job_postings table

try {
    $pdo = new PDO("mysql:host=localhost;dbname=apieclat;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Add mission column to job_postings table
    $sql = "ALTER TABLE job_postings ADD COLUMN mission TEXT AFTER description";
    $pdo->exec($sql);
    
    echo "Mission column added successfully to job_postings table.\n";
    
    // Verify the column was added
    $stmt = $pdo->query("DESCRIBE job_postings");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (in_array('mission', $columns)) {
        echo "Column verification successful.\n";
    } else {
        echo "Warning: Column may not have been added correctly.\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>