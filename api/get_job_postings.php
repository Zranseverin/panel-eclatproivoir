<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/JobPosting.php';

// Create job posting object
$job_posting = new JobPosting();

// Get all job postings
$stmt = $job_posting->getAll();
$num = $stmt->rowCount();

// Check if any job postings exist
if ($num > 0) {
    // Job postings array
    $job_postings_arr = array();
    $job_postings_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $job_posting_item = array(
            "id" => $id,
            "title" => $title,
            "employment_type" => $employment_type,
            "description" => $description,
            "mission" => $mission,
            "responsibilities" => $responsibilities,
            "profile_requirements" => $profile_requirements,
            "benefits" => $benefits,
            "image_url" => $image_url,
            "badge_text" => $badge_text,
            "badge_class" => $badge_class,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );

        array_push($job_postings_arr["records"], $job_posting_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show job postings data in json format
    echo json_encode($job_postings_arr, JSON_UNESCAPED_UNICODE);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no job postings found
    echo json_encode(
        array("message" => "No job postings found.")
    );
}
?>