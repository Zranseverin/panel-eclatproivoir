<?php
class Service {
    private $conn;
    private $table_name = "services";

    public $id;
    public $icon_class;
    public $title;
    public $description;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all services
    public function getAllServices() {
        $query = "SELECT id, icon_class, title, description, created_at, updated_at FROM " . $this->table_name . " ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get service by ID
    public function getServiceById($id) {
        $query = "SELECT id, icon_class, title, description, created_at, updated_at FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->icon_class = $row['icon_class'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }
}
?>