<?php
require_once 'Database.php';

class JobPosting {
    private $conn;
    private $table = 'job_postings';

    public $id;
    public $title;
    public $employment_type;
    public $description;
    public $mission;
    public $responsibilities;
    public $profile_requirements;
    public $benefits;
    public $image_url;
    public $badge_text;
    public $badge_class;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all active job postings
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single job posting by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? AND is_active = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Create a new job posting
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET title=:title, employment_type=:employment_type, description=:description, mission=:mission,
                      responsibilities=:responsibilities, profile_requirements=:profile_requirements,
                      benefits=:benefits, image_url=:image_url, badge_text=:badge_text,
                      badge_class=:badge_class, is_active=:is_active";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->employment_type = htmlspecialchars(strip_tags($this->employment_type));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->mission = htmlspecialchars(strip_tags($this->mission));
        $this->responsibilities = htmlspecialchars(strip_tags($this->responsibilities));
        $this->profile_requirements = htmlspecialchars(strip_tags($this->profile_requirements));
        $this->benefits = htmlspecialchars(strip_tags($this->benefits));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->badge_text = htmlspecialchars(strip_tags($this->badge_text));
        $this->badge_class = htmlspecialchars(strip_tags($this->badge_class));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":employment_type", $this->employment_type);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":mission", $this->mission);
        $stmt->bindParam(":responsibilities", $this->responsibilities);
        $stmt->bindParam(":profile_requirements", $this->profile_requirements);
        $stmt->bindParam(":benefits", $this->benefits);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":badge_text", $this->badge_text);
        $stmt->bindParam(":badge_class", $this->badge_class);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update a job posting
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET title=:title, employment_type=:employment_type, description=:description, mission=:mission,
                      responsibilities=:responsibilities, profile_requirements=:profile_requirements,
                      benefits=:benefits, image_url=:image_url, badge_text=:badge_text,
                      badge_class=:badge_class, is_active=:is_active
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->employment_type = htmlspecialchars(strip_tags($this->employment_type));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->mission = htmlspecialchars(strip_tags($this->mission));
        $this->responsibilities = htmlspecialchars(strip_tags($this->responsibilities));
        $this->profile_requirements = htmlspecialchars(strip_tags($this->profile_requirements));
        $this->benefits = htmlspecialchars(strip_tags($this->benefits));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->badge_text = htmlspecialchars(strip_tags($this->badge_text));
        $this->badge_class = htmlspecialchars(strip_tags($this->badge_class));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":employment_type", $this->employment_type);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":mission", $this->mission);
        $stmt->bindParam(":responsibilities", $this->responsibilities);
        $stmt->bindParam(":profile_requirements", $this->profile_requirements);
        $stmt->bindParam(":benefits", $this->benefits);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":badge_text", $this->badge_text);
        $stmt->bindParam(":badge_class", $this->badge_class);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a job posting (soft delete)
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