<?php
class PricingPlan {
    private $conn;
    private $table_name = "pricing_plans";

    public $id;
    public $title;
    public $subtitle;
    public $price;
    public $currency;
    public $period;
    public $image_url;
    public $features;
    public $cta_text;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all active pricing plans
    public function getAllActivePlans() {
        $query = "SELECT id, title, subtitle, price, currency, period, image_url, features, cta_text, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  WHERE is_active = 1
                  ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get pricing plan by ID
    public function getPlanById($id) {
        $query = "SELECT id, title, subtitle, price, currency, period, image_url, features, cta_text, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  WHERE id = ? AND is_active = 1
                  LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->subtitle = $row['subtitle'];
            $this->price = $row['price'];
            $this->currency = $row['currency'];
            $this->period = $row['period'];
            $this->image_url = $row['image_url'];
            $this->features = $row['features'];
            $this->cta_text = $row['cta_text'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Get all pricing plans (active and inactive)
    public function getAllPlans() {
        $query = "SELECT id, title, subtitle, price, currency, period, image_url, features, cta_text, is_active, created_at, updated_at 
                  FROM " . $this->table_name . " 
                  ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>