<?php
// Use absolute path for config file
$configPath = dirname(__FILE__) . '/../config/db_config.php';
if (file_exists($configPath)) {
    include_once $configPath;
} else {
    // Fallback to direct definition if config file not found
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'apieclat');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}

class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Set the character set for the connection
            $this->conn->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>