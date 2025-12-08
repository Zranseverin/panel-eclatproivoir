<?php
require_once 'Database.php';

class LogoConfig {
    private $conn;
    private $table = 'config_logo';

    public $id;
    public $logo_path;
    public $alt_text;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get logo configuration by ID (default to 1 for backward compatibility)
    public function getLogo($id = 1) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->logo_path = $row['logo_path'];
            $this->alt_text = $row['alt_text'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Get all logos
    public function getAllLogos() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update logo configuration
    public function updateLogo() {
        $query = "UPDATE " . $this->table . " 
                  SET logo_path=:logo_path, alt_text=:alt_text, updated_at=NOW()
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->logo_path = htmlspecialchars(strip_tags($this->logo_path));
        $this->alt_text = htmlspecialchars(strip_tags($this->alt_text));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":logo_path", $this->logo_path);
        $stmt->bindParam(":alt_text", $this->alt_text);

        return $stmt->execute();
    }

    // Create new logo configuration
    public function createLogo() {
        $query = "INSERT INTO " . $this->table . " 
                  SET logo_path=:logo_path, alt_text=:alt_text, created_at=NOW(), updated_at=NOW()";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->logo_path = htmlspecialchars(strip_tags($this->logo_path));
        $this->alt_text = htmlspecialchars(strip_tags($this->alt_text));

        // Bind values
        $stmt->bindParam(":logo_path", $this->logo_path);
        $stmt->bindParam(":alt_text", $this->alt_text);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    
    // Delete logo configuration
    public function deleteLogo($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>