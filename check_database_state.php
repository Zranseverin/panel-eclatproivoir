<?php
require_once 'classes/LogoConfig.php';

// Create logo config object
$logoConfig = new LogoConfig();

// Get all logos to see current database state
$logos = $logoConfig->getAllLogos();

echo "<h2>Current Database State:</h2>\n";
echo "<pre>" . json_encode($logos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>\n";

// Check if ID=1 exists
$logoExists = $logoConfig->getLogo(1);
if ($logoExists) {
    echo "<h2>Logo with ID=1:</h2>\n";
    echo "<pre>" . json_encode([
        "id" => (int)$logoConfig->id,
        "logo_path" => $logoConfig->logo_path,
        "alt_text" => $logoConfig->alt_text,
        "created_at" => $logoConfig->created_at,
        "updated_at" => $logoConfig->updated_at
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>\n";
} else {
    echo "<h2>No logo found with ID=1</h2>\n";
}
?>