<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Include database and object files
require_once '../classes/Testimonial.php';

// Get database connection
$testimonial = new Testimonial();

// Set ID property of testimonial to be edited
$testimonial->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of testimonial to be edited
$stmt = $testimonial->getById($testimonial->id);
$num = $stmt->rowCount();

if ($num > 0) {
    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Create array
    $testimonial_arr = array(
        "id" => $row['id'],
        "client_name" => $row['client_name'],
        "client_position" => $row['client_position'],
        "company" => $row['company'],
        "testimonial_text" => $row['testimonial_text'],
        "client_image_url" => $row['client_image_url'],
        "rating" => $row['rating'],
        "created_at" => $row['created_at'],
        "updated_at" => $row['updated_at']
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($testimonial_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user testimonial does not exist
    echo json_encode(array("message" => "Testimonial does not exist."));
}
?>