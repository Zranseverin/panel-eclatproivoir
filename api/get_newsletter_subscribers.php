<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/NewsletterSubscriber.php';

// Create newsletter subscriber object
$subscriber = new NewsletterSubscriber();

// Get all active subscribers
$stmt = $subscriber->getAllActive();
$num = $stmt->rowCount();

// Check if any subscribers exist
if ($num > 0) {
    // Subscribers array
    $subscribers_arr = array();
    $subscribers_arr["records"] = array();

    // Retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row
        extract($row);

        $subscriber_item = array(
            "id" => $id,
            "email" => $email,
            "subscribed_at" => $subscribed_at,
            "is_active" => $is_active
        );

        array_push($subscribers_arr["records"], $subscriber_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Show subscribers data in json format
    echo json_encode($subscribers_arr, JSON_UNESCAPED_UNICODE);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no subscribers found
    echo json_encode(
        array("message" => "Aucun abonné trouvé.")
    );
}
?>