<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'classes/JobApplication.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (
        !empty($_POST['civilite']) &&
        !empty($_POST['nom_complet']) &&
        !empty($_POST['telephone']) &&
        !empty($_POST['email']) &&
        !empty($_POST['adresse']) &&
        !empty($_POST['poste'])
    ) {
        // Create job application object
        $job_application = new JobApplication();
        
        // Set job application property values
        $job_application->civilite = htmlspecialchars(strip_tags($_POST['civilite']));
        $job_application->nom_complet = htmlspecialchars(strip_tags($_POST['nom_complet']));
        $job_application->telephone = htmlspecialchars(strip_tags($_POST['telephone']));
        $job_application->email = htmlspecialchars(strip_tags($_POST['email']));
        $job_application->adresse = htmlspecialchars(strip_tags($_POST['adresse']));
        $job_application->poste = htmlspecialchars(strip_tags($_POST['poste']));
        
        // Handle file uploads
        $cv_path = null;
        $lettre_motivation_path = null;
        
        // Create specific directories for CVs and cover letters if they don't exist
        $cv_upload_dir = 'eclatBack/back_office/storage/app/public/cvs/';
        $lm_upload_dir = 'eclatBack/back_office/storage/app/public/lettres_motivation/';
        
        // Ensure base upload directory exists
        $base_upload_dir = 'eclatBack/back_office/storage/app/public/';
        if (!file_exists($base_upload_dir)) {
            mkdir($base_upload_dir, 0777, true);
        }
        
        // Ensure CV directory exists
        if (!file_exists($cv_upload_dir)) {
            mkdir($cv_upload_dir, 0777, true);
        }
        
        // Ensure cover letter directory exists
        if (!file_exists($lm_upload_dir)) {
            mkdir($lm_upload_dir, 0777, true);
        }
        
        // Process CV upload
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
            $cv_filename = uniqid() . '_' . basename($_FILES['cv']['name']);
            $cv_target_file = $cv_upload_dir . $cv_filename;
            
            // Check file size (5MB limit)
            if ($_FILES['cv']['size'] <= 5000000) {
                // Allow certain file formats
                $cv_file_type = strtolower(pathinfo($cv_target_file, PATHINFO_EXTENSION));
                if (in_array($cv_file_type, ['pdf', 'doc', 'docx', 'txt'])) {
                    if (move_uploaded_file($_FILES['cv']['tmp_name'], $cv_target_file)) {
                        // Store relative path for database storage (as seen in your examples)
                        $cv_path = 'cvs/' . $cv_filename;
                    }
                }
            }
        }
        
        // Process cover letter upload
        if (isset($_FILES['lettre_motivation']) && $_FILES['lettre_motivation']['error'] == 0) {
            $lm_filename = uniqid() . '_' . basename($_FILES['lettre_motivation']['name']);
            $lm_target_file = $lm_upload_dir . $lm_filename;
            
            // Check file size (5MB limit)
            if ($_FILES['lettre_motivation']['size'] <= 5000000) {
                // Allow certain file formats
                $lm_file_type = strtolower(pathinfo($lm_target_file, PATHINFO_EXTENSION));
                if (in_array($lm_file_type, ['pdf', 'doc', 'docx', 'txt'])) {
                    if (move_uploaded_file($_FILES['lettre_motivation']['tmp_name'], $lm_target_file)) {
                        // Store relative path for database storage (as seen in your examples)
                        $lettre_motivation_path = 'lettres_motivation/' . $lm_filename;
                    }
                }
            }
        }
        
        // Set file paths
        $job_application->cv_path = $cv_path;
        $job_application->lettre_motivation_path = $lettre_motivation_path;
        
        // Create the job application
        if ($job_application->create()) {
            // Send response
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
} else {
    // Set response code - 405 method not allowed
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>