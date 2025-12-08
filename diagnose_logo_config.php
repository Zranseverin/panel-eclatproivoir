<?php
require_once 'classes/LogoConfig.php';

echo "<h2>Logo Configuration Diagnosis</h2>\n";

// Test by directly using the LogoConfig class
$logoConfig = new LogoConfig();

// We can't directly access private properties, so let's test indirectly
echo "<h3>Testing database connection and logo retrieval:</h3>\n";

// Test getting a specific logo
if ($logoConfig->getLogo()) {
    echo "<p>✅ Logo configuration found</p>\n";
    echo "<ul>\n";
    echo "<li>ID: " . htmlspecialchars($logoConfig->id) . "</li>\n";
    echo "<li>Logo Path: " . htmlspecialchars($logoConfig->logo_path) . "</li>\n";
    echo "<li>Alt Text: " . htmlspecialchars($logoConfig->alt_text) . "</li>\n";
    echo "<li>Created At: " . htmlspecialchars($logoConfig->created_at) . "</li>\n";
    echo "<li>Updated At: " . htmlspecialchars($logoConfig->updated_at) . "</li>\n";
    echo "</ul>\n";
    
    // Test constructing URL
    $logoPath = $logoConfig->logo_path;
    if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
        $logoUrl = $logoPath;
    } else {
        $fileName = basename($logoPath);
        $logoUrl = "http://127.0.0.1:8000/storage/logos/" . $fileName;
    }
    echo "<p>Constructed Logo URL: <a href='" . htmlspecialchars($logoUrl) . "' target='_blank'>" . htmlspecialchars($logoUrl) . "</a></p>\n";
} else {
    echo "<p>❌ No logo configuration found</p>\n";
    echo "<p>This could be because:</p>\n";
    echo "<ul>\n";
    echo "<li>The database connection is not working</li>\n";
    echo "<li>The config_logo table doesn't exist</li>\n";
    echo "<li>There's no record with ID = 1 in the config_logo table</li>\n";
    echo "</ul>\n";
}
?>