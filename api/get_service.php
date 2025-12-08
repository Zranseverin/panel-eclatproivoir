<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/Service.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare service object
$service = new Service($db);

// Set ID property of service to be edited
$service->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of service to be edited
if($service->getServiceById($service->id)) {
    // Create array
    $service_arr = array(
        "id" => $service->id,
        "icon_class" => $service->icon_class,
        "title" => $service->title,
        "description" => $service->description,
        "created_at" => $service->created_at,
        "updated_at" => $service->updated_at
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($service_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user service does not exist
    echo json_encode(array("message" => "Service does not exist."));
}
?>