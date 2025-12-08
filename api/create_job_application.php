<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../classes/JobApplication.php';

// Create job application object
$job_application = new JobApplication();

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->civilite) &&
    !empty($data->nom_complet) &&
    !empty($data->telephone) &&
    !empty($data->email) &&
    !empty($data->adresse) &&
    !empty($data->poste)
) {
    // Set job application property values
    $job_application->civilite = $data->civilite;
    $job_application->nom_complet = $data->nom_complet;
    $job_application->telephone = $data->telephone;
    $job_application->email = $data->email;
    $job_application->adresse = $data->adresse;
    $job_application->poste = $data->poste;
    
    // Handle file paths if provided
    $job_application->cv_path = !empty($data->cv_path) ? $data->cv_path : null;
    $job_application->lettre_motivation_path = !empty($data->lettre_motivation_path) ? $data->lettre_motivation_path : null;

    // Create the job application
    if ($job_application->create()) {
        // Set response code - 201 created
        http_response_code(201);
        echo json_encode(array(
            "message" => "Candidature soumise avec succès.",
            "application_id" => $job_application->id
        ));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de soumettre la candidature."));
    }
} else {
    // Set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de soumettre la candidature. Données incomplètes."));
}
?>