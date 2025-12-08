<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json; charset=UTF-8');

// Include database and object files
require_once '../classes/JobPosting.php';

// Get database connection
$job_posting = new JobPosting();

// Set ID property of job posting to be edited
$job_posting->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of job posting to be edited
$stmt = $job_posting->getById($job_posting->id);
$num = $stmt->rowCount();

if ($num > 0) {
    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Create array
    $job_posting_arr = array(
        "id" => $row['id'],
        "title" => $row['title'],
        "employment_type" => $row['employment_type'],
        "description" => $row['description'],
        "mission" => $row['mission'],
        "responsibilities" => $row['responsibilities'],
        "profile_requirements" => $row['profile_requirements'],
        "benefits" => $row['benefits'],
        "image_url" => $row['image_url'],
        "badge_text" => $row['badge_text'],
        "badge_class" => $row['badge_class'],
        "created_at" => $row['created_at'],
        "updated_at" => $row['updated_at']
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($job_posting_arr, JSON_UNESCAPED_UNICODE);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user job posting does not exist
    echo json_encode(array("message" => "Job posting does not exist."));
}
?>