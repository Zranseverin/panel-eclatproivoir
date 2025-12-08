<?php
require_once 'Database.php';

class HeroContent {
    private $conn;
    private $table = 'hero_content';

    public $id;
    public $headline;
    public $subheading;
    public $primary_button_text;
    public $primary_button_link;
    public $secondary_button_text;
    public $secondary_button_link;
    public $background_image_url;
    public $background_color;
    public $text_color;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get active hero content
    public function getActive() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get hero content by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? AND is_active = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Create new hero content
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET headline=:headline, subheading=:subheading, 
                      primary_button_text=:primary_button_text, primary_button_link=:primary_button_link,
                      secondary_button_text=:secondary_button_text, secondary_button_link=:secondary_button_link,
                      background_image_url=:background_image_url, background_color=:background_color, 
                      text_color=:text_color, is_active=:is_active";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->headline = htmlspecialchars(strip_tags($this->headline));
        $this->subheading = htmlspecialchars(strip_tags($this->subheading));
        $this->primary_button_text = htmlspecialchars(strip_tags($this->primary_button_text));
        $this->primary_button_link = htmlspecialchars(strip_tags($this->primary_button_link));
        $this->secondary_button_text = htmlspecialchars(strip_tags($this->secondary_button_text));
        $this->secondary_button_link = htmlspecialchars(strip_tags($this->secondary_button_link));
        $this->background_image_url = htmlspecialchars(strip_tags($this->background_image_url));
        $this->background_color = htmlspecialchars(strip_tags($this->background_color));
        $this->text_color = htmlspecialchars(strip_tags($this->text_color));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":headline", $this->headline);
        $stmt->bindParam(":subheading", $this->subheading);
        $stmt->bindParam(":primary_button_text", $this->primary_button_text);
        $stmt->bindParam(":primary_button_link", $this->primary_button_link);
        $stmt->bindParam(":secondary_button_text", $this->secondary_button_text);
        $stmt->bindParam(":secondary_button_link", $this->secondary_button_link);
        $stmt->bindParam(":background_image_url", $this->background_image_url);
        $stmt->bindParam(":background_color", $this->background_color);
        $stmt->bindParam(":text_color", $this->text_color);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update hero content
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET headline=:headline, subheading=:subheading,
                      primary_button_text=:primary_button_text, primary_button_link=:primary_button_link,
                      secondary_button_text=:secondary_button_text, secondary_button_link=:secondary_button_link,
                      background_image_url=:background_image_url, background_color=:background_color, 
                      text_color=:text_color, is_active=:is_active
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->headline = htmlspecialchars(strip_tags($this->headline));
        $this->subheading = htmlspecialchars(strip_tags($this->subheading));
        $this->primary_button_text = htmlspecialchars(strip_tags($this->primary_button_text));
        $this->primary_button_link = htmlspecialchars(strip_tags($this->primary_button_link));
        $this->secondary_button_text = htmlspecialchars(strip_tags($this->secondary_button_text));
        $this->secondary_button_link = htmlspecialchars(strip_tags($this->secondary_button_link));
        $this->background_image_url = htmlspecialchars(strip_tags($this->background_image_url));
        $this->background_color = htmlspecialchars(strip_tags($this->background_color));
        $this->text_color = htmlspecialchars(strip_tags($this->text_color));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":headline", $this->headline);
        $stmt->bindParam(":subheading", $this->subheading);
        $stmt->bindParam(":primary_button_text", $this->primary_button_text);
        $stmt->bindParam(":primary_button_link", $this->primary_button_link);
        $stmt->bindParam(":secondary_button_text", $this->secondary_button_text);
        $stmt->bindParam(":secondary_button_link", $this->secondary_button_link);
        $stmt->bindParam(":background_image_url", $this->background_image_url);
        $stmt->bindParam(":background_color", $this->background_color);
        $stmt->bindParam(":text_color", $this->text_color);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete hero content (soft delete)
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