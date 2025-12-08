<?php
echo "<h2>Check Logo Files</h2>\n";

$logosDir = "eclatBack/back_office/storage/app/public/logos/";

echo "<p>Checking directory: " . htmlspecialchars($logosDir) . "</p>\n";

if (is_dir($logosDir)) {
    echo "<p>✅ Logos directory exists</p>\n";
    
    $files = scandir($logosDir);
    if ($files !== false) {
        echo "<p>Files in logos directory:</p>\n";
        echo "<ul>\n";
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $logosDir . $file;
                $fileSize = file_exists($filePath) ? filesize($filePath) : 'Unknown';
                echo "<li>" . htmlspecialchars($file) . " (" . $fileSize . " bytes)</li>\n";
            }
        }
        echo "</ul>\n";
    } else {
        echo "<p>❌ Failed to read directory</p>\n";
    }
} else {
    echo "<p>❌ Logos directory does not exist</p>\n";
    
    // Try alternative paths
    $alternativePaths = [
        "../eclatBack/back_office/storage/app/public/logos/",
        "c:/xampp/htdocs/ivoirPro/eclatBack/back_office/storage/app/public/logos/"
    ];
    
    foreach ($alternativePaths as $path) {
        echo "<p>Checking alternative path: " . htmlspecialchars($path) . "</p>\n";
        if (is_dir($path)) {
            echo "<p>✅ Found logos directory at alternative path</p>\n";
            break;
        }
    }
}
?>