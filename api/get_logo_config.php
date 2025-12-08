<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../classes/LogoConfig.php';

// Create logo config object
$logoConfig = new LogoConfig();

// Get logo ID from query parameter, or default to 1
$logoId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Try to get the specified logo
if ($logoConfig->getLogo($logoId)) {
    // Determine the logo URL
    $logoPath = $logoConfig->logo_path;
    
    // Check if it's already a full URL
    if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
        $logoUrl = $logoPath;
    } else {
        // It's a relative path, construct the full URL
        // Handle both storage/logos/filename.png and just filename.png formats
        $fileName = basename($logoPath);
        $logoUrl = "http://127.0.0.1:8000/storage/logos/" . $fileName;
    }
    
    // Create array
    $logo_arr = array(
        "id" => (int)$logoConfig->id,
        "logo_path" => $logoConfig->logo_path,
        "logo_url" => $logoUrl,
        "alt_text" => $logoConfig->alt_text ?: "EclatPro Logo",
        "updated_at" => $logoConfig->updated_at
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($logo_arr, JSON_UNESCAPED_UNICODE);
} else {
    // If the specified ID doesn't exist, try to get the first available logo
    $allLogos = $logoConfig->getAllLogos();
    if (!empty($allLogos)) {
        // Get the first logo
        $firstLogo = $allLogos[0];
        
        // Set the logo config properties
        $logoConfig->id = $firstLogo['id'];
        $logoConfig->logo_path = $firstLogo['logo_path'];
        $logoConfig->alt_text = $firstLogo['alt_text'];
        $logoConfig->updated_at = $firstLogo['updated_at'];
        
        // Determine the logo URL
        $logoPath = $logoConfig->logo_path;
        
        // Check if it's already a full URL
        if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
            $logoUrl = $logoPath;
        } else {
            // It's a relative path, construct the full URL
            $fileName = basename($logoPath);
            $logoUrl = "http://127.0.0.1:8000/storage/logos/" . $fileName;
        }
        
        // Create array
        $logo_arr = array(
            "id" => (int)$logoConfig->id,
            "logo_path" => $logoConfig->logo_path,
            "logo_url" => $logoUrl,
            "alt_text" => $logoConfig->alt_text ?: "EclatPro Logo",
            "updated_at" => $logoConfig->updated_at
        );

        // Set response code - 200 OK
        http_response_code(200);

        // Make it json format
        echo json_encode($logo_arr, JSON_UNESCAPED_UNICODE);
    } else {
        // Set response code - 404 Not found
        http_response_code(404);

        // Tell the user logo config does not exist
        echo json_encode(array("message" => "Aucun logo trouvé dans la base de données."));
    }
}
?>