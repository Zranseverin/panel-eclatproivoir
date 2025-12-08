<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/TeamMember.php';

$database = new Database();
$db = $database->getConnection();

$teamMember = new TeamMember($db);

$stmt = $teamMember->getAllActiveMembers();
$num = $stmt->rowCount();

if($num > 0) {
    $members_arr = array();
    $members_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $member_item = array(
            "id" => $id,
            "name" => $name,
            "role" => $role,
            "bio" => $bio,
            "image_url" => $image_url,
            "twitter_url" => $twitter_url,
            "facebook_url" => $facebook_url,
            "linkedin_url" => $linkedin_url,
            "is_active" => $is_active,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        
        array_push($members_arr["records"], $member_item);
    }
    
    http_response_code(200);
    echo json_encode($members_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No team members found."));
}
?>