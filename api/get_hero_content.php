<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/HeroContent.php';

// Create hero content object
$hero_content = new HeroContent();

// Get active hero content
$stmt = $hero_content->getActive();
$num = $stmt->rowCount();

// Check if any hero content exists
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

    // Show hero content data in json format
    echo json_encode($hero_content_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no hero content found
    echo json_encode(
        array("message" => "No hero content found.")
    );
}
?>