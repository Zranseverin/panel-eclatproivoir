<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/LogoConfig.php';

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    // Create logo config object
    $logoConfig = new LogoConfig();
    
    // Delete the logo configuration
    if ($logoConfig->deleteLogo($data->id)) {
        // Set response code - 200 ok
        http_response_code(200);
        echo json_encode(array("message" => "Logo supprimé avec succès."));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de supprimer le logo."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de supprimer le logo. ID requis."));
}
?>