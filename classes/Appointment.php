<?php
class Appointment {
    private $conn;
    private $table_name = "appointments";

    public $id;
    public $service_type;
    public $frequency;
    public $name;
    public $email;
    public $desired_date;
    public $phone;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create appointment
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET service_type=:service_type, frequency=:frequency, name=:name, 
                      email=:email, desired_date=:desired_date, phone=:phone";

        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->service_type = htmlspecialchars(strip_tags($this->service_type));
        $this->frequency = htmlspecialchars(strip_tags($this->frequency));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->desired_date = htmlspecialchars(strip_tags($this->desired_date));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        // Bind values
        $stmt->bindParam(":service_type", $this->service_type);
        $stmt->bindParam(":frequency", $this->frequency);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":desired_date", $this->desired_date);
        $stmt->bindParam(":phone", $this->phone);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all appointments
    public function getAllAppointments() {
        $query = "SELECT id, service_type, frequency, name, email, desired_date, phone, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get appointment by ID
    public function getAppointmentById($id) {
        $query = "SELECT id, service_type, frequency, name, email, desired_date, phone, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->service_type = $row['service_type'];
            $this->frequency = $row['frequency'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->desired_date = $row['desired_date'];
            $this->phone = $row['phone'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }
}
?>