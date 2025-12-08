<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Include database and object files
require_once '../classes/BlogPost.php';

// Get database connection
$blog_post = new BlogPost();

// Set ID property of blog post to be edited
$blog_post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of blog post to be edited
$stmt = $blog_post->getById($blog_post->id);
$num = $stmt->rowCount();

if ($num > 0) {
    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Create array
    $blog_post_arr = array(
        "id" => $row['id'],
        "title" => $row['title'],
        "subtitle" => $row['subtitle'],
        "content" => $row['content'],
        "image_url" => $row['image_url'],
        "author" => $row['author'],
        "author_image_url" => $row['author_image_url'],
        "views" => $row['views'],
        "comments" => $row['comments'],
        "created_at" => $row['created_at'],
        "updated_at" => $row['updated_at']
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($blog_post_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user blog post does not exist
    echo json_encode(array("message" => "Blog post does not exist."));
}
?>