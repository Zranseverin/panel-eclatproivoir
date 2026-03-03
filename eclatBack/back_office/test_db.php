<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=eclat_back', 'laravel', 'password123');
    echo "Connection successful\n";
    
    // Test a simple query
    $stmt = $pdo->query('SELECT 1');
    $result = $stmt->fetch();
    echo "Query result: " . print_r($result, true) . "\n";
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}