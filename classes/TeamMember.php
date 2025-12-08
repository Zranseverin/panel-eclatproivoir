<?php
class TeamMember {
    private $conn;
    private $table_name = "team_members";

    public $id;
    public $name;
    public $role;
    public $bio;
    public $image_url;
    public $twitter_url;
    public $facebook_url;
    public $linkedin_url;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all active team members
    public function getAllActiveMembers() {
        $query = "SELECT id, name, role, bio, image_url, twitter_url, facebook_url, linkedin_url, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  WHERE is_active = 1
                  ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get team member by ID
    public function getMemberById($id) {
        $query = "SELECT id, name, role, bio, image_url, twitter_url, facebook_url, linkedin_url, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  WHERE id = ? AND is_active = 1
                  LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->role = $row['role'];
            $this->bio = $row['bio'];
            $this->image_url = $row['image_url'];
            $this->twitter_url = $row['twitter_url'];
            $this->facebook_url = $row['facebook_url'];
            $this->linkedin_url = $row['linkedin_url'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Get all team members (active and inactive)
    public function getAllMembers() {
        $query = "SELECT id, name, role, bio, image_url, twitter_url, facebook_url, linkedin_url, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>