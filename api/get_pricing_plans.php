<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/PricingPlan.php';

$database = new Database();
$db = $database->getConnection();

$pricingPlan = new PricingPlan($db);

$stmt = $pricingPlan->getAllActivePlans();
$num = $stmt->rowCount();

if($num > 0) {
    $plans_arr = array();
    $plans_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        // Convert features string to array
        $features_array = explode(',', $features);
        
        $plan_item = array(
            "id" => $id,
            "title" => $title,
            "subtitle" => $subtitle,
            "price" => $price,
            "currency" => $currency,
            "period" => $period,
            "image_url" => $image_url,
            "features" => $features_array,
            "cta_text" => $cta_text,
            "is_active" => $is_active,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        
        array_push($plans_arr["records"], $plan_item);
    }
    
    http_response_code(200);
    echo json_encode($plans_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No pricing plans found."));
}
?>