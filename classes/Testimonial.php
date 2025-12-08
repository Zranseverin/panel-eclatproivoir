<?php
require_once 'Database.php';

class Testimonial {
    private $conn;
    private $table = 'testimonials';

    public $id;
    public $client_name;
    public $client_position;
    public $company;
    public $testimonial_text;
    public $client_image_url;
    public $rating;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all active testimonials
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single testimonial by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? AND is_active = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Create a new testimonial
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET client_name=:client_name, client_position=:client_position, company=:company, 
                      testimonial_text=:testimonial_text, client_image_url=:client_image_url,
                      rating=:rating, is_active=:is_active";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->client_name = htmlspecialchars(strip_tags($this->client_name));
        $this->client_position = htmlspecialchars(strip_tags($this->client_position));
        $this->company = htmlspecialchars(strip_tags($this->company));
        $this->testimonial_text = htmlspecialchars(strip_tags($this->testimonial_text));
        $this->client_image_url = htmlspecialchars(strip_tags($this->client_image_url));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":client_name", $this->client_name);
        $stmt->bindParam(":client_position", $this->client_position);
        $stmt->bindParam(":company", $this->company);
        $stmt->bindParam(":testimonial_text", $this->testimonial_text);
        $stmt->bindParam(":client_image_url", $this->client_image_url);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update a testimonial
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET client_name=:client_name, client_position=:client_position, company=:company,
                      testimonial_text=:testimonial_text, client_image_url=:client_image_url,
                      rating=:rating, is_active=:is_active
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->client_name = htmlspecialchars(strip_tags($this->client_name));
        $this->client_position = htmlspecialchars(strip_tags($this->client_position));
        $this->company = htmlspecialchars(strip_tags($this->company));
        $this->testimonial_text = htmlspecialchars(strip_tags($this->testimonial_text));
        $this->client_image_url = htmlspecialchars(strip_tags($this->client_image_url));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":client_name", $this->client_name);
        $stmt->bindParam(":client_position", $this->client_position);
        $stmt->bindParam(":company", $this->company);
        $stmt->bindParam(":testimonial_text", $this->testimonial_text);
        $stmt->bindParam(":client_image_url", $this->client_image_url);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a testimonial (soft delete)
    public function delete() {
        $query = "UPDATE " . $this->table . " SET is_active = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind value
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>