<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/NewsletterSubscriber.php';

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email)) {
    // Validate email format
    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        // Set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array("message" => "Format d'email invalide."));
        return;
    }

    // Create newsletter subscriber object
    $subscriber = new NewsletterSubscriber();
    $subscriber->email = $data->email;

    // Try to subscribe
    if ($subscriber->subscribe()) {
        // Set response code - 201 created
        http_response_code(201);
        echo json_encode(array(
            "message" => "Inscription à la newsletter réussie.",
            "email" => $subscriber->email
        ));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de s'inscrire à la newsletter."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de s'inscrire. Email requis."));
}
?>