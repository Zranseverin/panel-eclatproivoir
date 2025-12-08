<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/PricingPlan.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare pricing plan object
$pricingPlan = new PricingPlan($db);

// Set ID property of pricing plan to be edited
$pricingPlan->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of pricing plan to be edited
if($pricingPlan->getPlanById($pricingPlan->id)) {
    // Convert features string to array
    $features_array = explode(',', $pricingPlan->features);
    
    // Create array
    $pricing_plan_arr = array(
        "id" => $pricingPlan->id,
        "title" => $pricingPlan->title,
        "subtitle" => $pricingPlan->subtitle,
        "price" => $pricingPlan->price,
        "currency" => $pricingPlan->currency,
        "period" => $pricingPlan->period,
        "image_url" => $pricingPlan->image_url,
        "features" => $features_array,
        "cta_text" => $pricingPlan->cta_text,
        "is_active" => $pricingPlan->is_active,
        "created_at" => $pricingPlan->created_at,
        "updated_at" => $pricingPlan->updated_at
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($pricing_plan_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user pricing plan does not exist
    echo json_encode(array("message" => "Pricing plan does not exist."));
}
?>