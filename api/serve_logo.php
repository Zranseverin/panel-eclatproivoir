<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");

require_once '../classes/LogoConfig.php';

// Get the logo ID from the URL parameter, default to 1
$logoId = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Create logo config object
$logoConfig = new LogoConfig();
$logoConfig->id = $logoId;

// Get logo configuration
if ($logoConfig->getLogo()) {
    // Determine the file path
    $logoPath = $logoConfig->logo_path;
    
    // If it's a URL, extract the filename
    if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
        $filename = basename(parse_url($logoPath, PHP_URL_PATH));
        $filePath = "../../eclatBack/back_office/storage/app/public/logos/" . $filename;
    } else {
        // It's a relative path
        $filename = basename($logoPath);
        $filePath = "../../eclatBack/back_office/storage/app/public/logos/" . $filename;
    }
    
    // Check if file exists
    if (file_exists($filePath) && is_readable($filePath)) {
        // Get the MIME type
        $mimeType = mime_content_type($filePath);
        
        // Set appropriate headers
        header("Content-Type: " . $mimeType);
        header("Content-Length: " . filesize($filePath));
        
        // Output the file
        readfile($filePath);
        exit;
    } else {
        // File not found
        http_response_code(404);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(array("message" => "Logo file not found."));
    }
} else {
    // Logo configuration not found
    http_response_code(404);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(array("message" => "Logo configuration not found."));
}
?>