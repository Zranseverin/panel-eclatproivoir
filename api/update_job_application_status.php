<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/JobApplication.php';

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->status)) {
    // Create job application object
    $job_application = new JobApplication();
    
    // Set ID and status
    $job_application->id = $data->id;
    
    // Update status
    if ($job_application->updateStatus($data->status)) {
        // Set response code - 200 ok
        http_response_code(200);
        echo json_encode(array("message" => "Statut de la candidature mis à jour avec succès."));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de mettre à jour le statut de la candidature."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour le statut. Données incomplètes."));
}
?>