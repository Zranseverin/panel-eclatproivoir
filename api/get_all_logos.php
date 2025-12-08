<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/LogoConfig.php';

// Create logo config object
$logoConfig = new LogoConfig();

// Get all logos
$logos = $logoConfig->getAllLogos();

if (count($logos) > 0) {
    // Process each logo to construct proper URLs
    $processedLogos = array();
    foreach ($logos as $logo) {
        // Determine the logo URL
        $logoPath = $logo['logo_path'];
        
        // Check if it's already a full URL
        if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
            $logoUrl = $logoPath;
        } else {
            // It's a relative path, construct the full URL
            $fileName = basename($logoPath);
            $logoUrl = "http://127.0.0.1:8000/storage/logos/" . $fileName;
        }
        
        $processedLogos[] = array(
            "id" => (int)$logo['id'],
            "logo_path" => $logo['logo_path'],
            "logo_url" => $logoUrl,
            "alt_text" => $logo['alt_text'] ?: "Logo",
            "created_at" => $logo['created_at'],
            "updated_at" => $logo['updated_at']
        );
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($processedLogos, JSON_UNESCAPED_UNICODE);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user no logos found
    echo json_encode(array("message" => "Aucun logo trouvé."));
}
?>