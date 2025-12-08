<?php
require_once 'Database.php';

class BlogPost {
    private $conn;
    private $table = 'blog_posts';

    public $id;
    public $title;
    public $subtitle;
    public $content;
    public $image_url;
    public $author;
    public $author_image_url;
    public $views;
    public $comments;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all active blog posts
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " WHERE is_active = 1 ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get a single blog post by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? AND is_active = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Create a new blog post
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET title=:title, subtitle=:subtitle, content=:content, 
                      image_url=:image_url, author=:author, author_image_url=:author_image_url,
                      views=:views, comments=:comments, is_active=:is_active";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->subtitle = htmlspecialchars(strip_tags($this->subtitle));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->author_image_url = htmlspecialchars(strip_tags($this->author_image_url));
        $this->views = htmlspecialchars(strip_tags($this->views));
        $this->comments = htmlspecialchars(strip_tags($this->comments));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":subtitle", $this->subtitle);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":author_image_url", $this->author_image_url);
        $stmt->bindParam(":views", $this->views);
        $stmt->bindParam(":comments", $this->comments);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update a blog post
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET title=:title, subtitle=:subtitle, content=:content,
                      image_url=:image_url, author=:author, author_image_url=:author_image_url,
                      views=:views, comments=:comments, is_active=:is_active
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->subtitle = htmlspecialchars(strip_tags($this->subtitle));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->author_image_url = htmlspecialchars(strip_tags($this->author_image_url));
        $this->views = htmlspecialchars(strip_tags($this->views));
        $this->comments = htmlspecialchars(strip_tags($this->comments));
        $this->is_active = htmlspecialchars(strip_tags($this->is_active));

        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":subtitle", $this->subtitle);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":author_image_url", $this->author_image_url);
        $stmt->bindParam(":views", $this->views);
        $stmt->bindParam(":comments", $this->comments);
        $stmt->bindParam(":is_active", $this->is_active);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a blog post (soft delete)
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