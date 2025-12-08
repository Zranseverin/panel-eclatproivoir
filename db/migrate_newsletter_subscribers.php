<?php
// Migration script for newsletter_subscribers table

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'apieclat');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the newsletter_subscribers table
    $sql = "
    CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_active TINYINT(1) DEFAULT 1
    )";
    
    $pdo->exec($sql);
    
    echo "newsletter_subscribers table created/updated successfully.\n";
    
    // Create indexes
    $indexes = [
        "CREATE INDEX idx_email ON newsletter_subscribers(email)",
        "CREATE INDEX idx_is_active ON newsletter_subscribers(is_active)",
        "CREATE INDEX idx_subscribed_at ON newsletter_subscribers(subscribed_at)"
    ];
    
    foreach ($indexes as $indexSql) {
        try {
            $pdo->exec($indexSql);
            echo "Index created: " . $indexSql . "\n";
        } catch (PDOException $e) {
            // Index might already exist, which is fine
            echo "Index skipped (may already exist): " . $indexSql . "\n";
        }
    }
    
    // Verify the table structure
    $stmt = $pdo->query("DESCRIBE newsletter_subscribers");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Table structure verified:\n";
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " " . $column['Type'];
        if ($column['Null'] === 'NO') echo " NOT NULL";
        if ($column['Key'] === 'PRI') echo " PRIMARY KEY";
        if ($column['Extra']) echo " " . $column['Extra'];
        echo "\n";
    }
    
    echo "Migration completed successfully.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>