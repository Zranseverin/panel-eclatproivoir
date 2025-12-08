<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/JobApplication.php';

// Create job application object
$job_application = new JobApplication();

// Get all job applications
$stmt = $job_application->getAll();
$num = $stmt->rowCount();

// Check if any job applications exist
if ($num > 0) {
    // Job applications array
    $job_applications_arr = array();
    $job_applications_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $job_application_item = array(
            "id" => $id,
            "civilite" => $civilite,
            "nom_complet" => $nom_complet,
            "telephone" => $telephone,
            "email" => $email,
            "adresse" => $adresse,
            "poste" => $poste,
            "cv_path" => $cv_path,
            "lettre_motivation_path" => $lettre_motivation_path,
            "submitted_at" => $submitted_at,
            "status" => $status
        );

        array_push($job_applications_arr["records"], $job_application_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show job applications data in json format
    echo json_encode($job_applications_arr, JSON_UNESCAPED_UNICODE);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no job applications found
    echo json_encode(
        array("message" => "No job applications found.")
    );
}
?>