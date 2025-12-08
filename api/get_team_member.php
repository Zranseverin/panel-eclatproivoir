<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/TeamMember.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare team member object
$teamMember = new TeamMember($db);

// Set ID property of team member to be edited
$teamMember->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of team member to be edited
if($teamMember->getMemberById($teamMember->id)) {
    // Create array
    $team_member_arr = array(
        "id" => $teamMember->id,
        "name" => $teamMember->name,
        "role" => $teamMember->role,
        "bio" => $teamMember->bio,
        "image_url" => $teamMember->image_url,
        "twitter_url" => $teamMember->twitter_url,
        "facebook_url" => $teamMember->facebook_url,
        "linkedin_url" => $teamMember->linkedin_url,
        "is_active" => $teamMember->is_active,
        "created_at" => $teamMember->created_at,
        "updated_at" => $teamMember->updated_at
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($team_member_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user team member does not exist
    echo json_encode(array("message" => "Team member does not exist."));
}
?>