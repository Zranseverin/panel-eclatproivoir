<?php
require_once 'Database.php';

class NewsletterSubscriber {
    private $conn;
    private $table = 'newsletter_subscribers';

    public $id;
    public $email;
    public $subscribed_at;
    public $is_active;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Subscribe a new email
    public function subscribe() {
        // Check if email already exists
        if ($this->emailExists()) {
            // If email exists but is inactive, reactivate it
            return $this->reactivateEmail();
        } else {
            // Insert new subscriber
            $query = "INSERT INTO " . $this->table . " SET email=:email, is_active=:is_active";
            $stmt = $this->conn->prepare($query);

            // Sanitize email
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->is_active = 1;

            // Bind values
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":is_active", $this->is_active);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }
    }

    // Check if email already exists
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Reactivate an existing email
    public function reactivateEmail() {
        $query = "UPDATE " . $this->table . " SET is_active = 1, subscribed_at = CURRENT_TIMESTAMP WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Sanitize email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind values
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }

    // Unsubscribe an email
    public function unsubscribe() {
        $query = "UPDATE " . $this->table . " SET is_active = 0 WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Sanitize email
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind values
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }

    // Get all active subscribers
    public function getAllActive() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY subscribed_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get subscriber by email
    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        return $stmt;
    }
}
?>