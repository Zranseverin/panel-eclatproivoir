<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/LogoConfig.php';

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->logo_path)) {
    // Create logo config object
    $logoConfig = new LogoConfig();
    
    // Set logo config property values
    $logoConfig->logo_path = $data->logo_path;
    $logoConfig->alt_text = !empty($data->alt_text) ? $data->alt_text : 'Logo';

    // Create the logo configuration
    if ($logoConfig->createLogo()) {
        // Set response code - 201 created
        http_response_code(201);
        echo json_encode(array(
            "message" => "Logo créé avec succès.",
            "id" => $logoConfig->id
        ));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de créer le logo."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de créer le logo. Chemin du logo requis."));
}
?>