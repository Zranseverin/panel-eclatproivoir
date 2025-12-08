<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/Testimonial.php';

// Create testimonial object
$testimonial = new Testimonial();

// Get all testimonials
$stmt = $testimonial->getAll();
$num = $stmt->rowCount();

// Check if any testimonials exist
if ($num > 0) {
    // Testimonials array
    $testimonials_arr = array();
    $testimonials_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $testimonial_item = array(
            "id" => $id,
            "client_name" => $client_name,
            "client_position" => $client_position,
            "company" => $company,
            "testimonial_text" => $testimonial_text,
            "client_image_url" => $client_image_url,
            "rating" => $rating,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );

        array_push($testimonials_arr["records"], $testimonial_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show testimonials data in json format
    echo json_encode($testimonials_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no testimonials found
    echo json_encode(
        array("message" => "No testimonials found.")
    );
}
?>