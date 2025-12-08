<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Include database and object files
require_once '../classes/HeroContent.php';

// Get database connection
$hero_content = new HeroContent();

// Set ID property of hero content to be edited
$hero_content->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of hero content to be edited
$stmt = $hero_content->getById($hero_content->id);
$num = $stmt->rowCount();

if ($num > 0) {
    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Create array
    $hero_content_arr = array(
        "id" => $row['id'],
        "headline" => $row['headline'],
        "subheading" => $row['subheading'],
        "primary_button_text" => $row['primary_button_text'],
        "primary_button_link" => $row['primary_button_link'],
        "secondary_button_text" => $row['secondary_button_text'],
        "secondary_button_link" => $row['secondary_button_link'],
        "background_image_url" => $row['background_image_url'],
        "background_color" => $row['background_color'],
        "text_color" => $row['text_color'],
        "created_at" => $row['created_at'],
        "updated_at" => $row['updated_at']
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($hero_content_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user hero content does not exist
    echo json_encode(array("message" => "Hero content does not exist."));
}
?>