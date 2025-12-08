<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/BlogPost.php';

// Create blog post object
$blog_post = new BlogPost();

// Get all blog posts
$stmt = $blog_post->getAll();
$num = $stmt->rowCount();

// Check if any blog posts exist
if ($num > 0) {
    // Blog posts array
    $blog_posts_arr = array();
    $blog_posts_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $blog_post_item = array(
            "id" => $id,
            "title" => $title,
            "subtitle" => $subtitle,
            "content" => $content,
            "image_url" => $image_url,
            "author" => $author,
            "author_image_url" => $author_image_url,
            "views" => $views,
            "comments" => $comments,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );

        array_push($blog_posts_arr["records"], $blog_post_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show blog posts data in json format
    echo json_encode($blog_posts_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no blog posts found
    echo json_encode(
        array("message" => "No blog posts found.")
    );
}
?>