<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/LogoConfig.php';

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->logo_path)) {
    // Create logo config object
    $logoConfig = new LogoConfig();
    
    // Set logo config property values
    $logoConfig->id = $data->id;
    $logoConfig->logo_path = $data->logo_path;
    $logoConfig->alt_text = !empty($data->alt_text) ? $data->alt_text : 'Logo';

    // Update the logo configuration
    if ($logoConfig->updateLogo()) {
        // Set response code - 200 ok
        http_response_code(200);
        echo json_encode(array("message" => "Logo mis à jour avec succès."));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de mettre à jour le logo."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour le logo. ID et chemin du logo requis."));
}
?>