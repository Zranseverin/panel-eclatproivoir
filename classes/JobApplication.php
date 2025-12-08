<?php
require_once 'Database.php';

class JobApplication {
    private $conn;
    private $table = 'job_applications';

    public $id;
    public $civilite;
    public $nom_complet;
    public $telephone;
    public $email;
    public $adresse;
    public $poste;
    public $cv_path;
    public $lettre_motivation_path;
    public $submitted_at;
    public $status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Create a new job application
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET civilite=:civilite, nom_complet=:nom_complet, telephone=:telephone, 
                      email=:email, adresse=:adresse, poste=:poste, 
                      cv_path=:cv_path, lettre_motivation_path=:lettre_motivation_path";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->civilite = htmlspecialchars(strip_tags($this->civilite));
        $this->nom_complet = htmlspecialchars(strip_tags($this->nom_complet));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->poste = htmlspecialchars(strip_tags($this->poste));
        $this->cv_path = htmlspecialchars(strip_tags($this->cv_path));
        $this->lettre_motivation_path = htmlspecialchars(strip_tags($this->lettre_motivation_path));

        // Bind values
        $stmt->bindParam(":civilite", $this->civilite);
        $stmt->bindParam(":nom_complet", $this->nom_complet);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":poste", $this->poste);
        $stmt->bindParam(":cv_path", $this->cv_path);
        $stmt->bindParam(":lettre_motivation_path", $this->lettre_motivation_path);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Get all job applications
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY submitted_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get job applications by position
    public function getByPosition($poste) {
        $query = "SELECT * FROM " . $this->table . " WHERE poste = ? ORDER BY submitted_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $poste);
        $stmt->execute();
        return $stmt;
    }

    // Get a single job application by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }

    // Update application status
    public function updateStatus($status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $status = htmlspecialchars(strip_tags($status));
        
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":status", $status);
        
        return $stmt->execute();
    }
}
?>