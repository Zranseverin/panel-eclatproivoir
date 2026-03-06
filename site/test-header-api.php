<?php
/**
 * Test Header Contact API
 */
require_once 'config.php';

echo "<!DOCTYPE html>\n";
echo "<html lang='en'>\n";
echo "<head><meta charset='UTF-8'><title>Header Contact API Test</title></head>\n";
echo "<body style='font-family: Arial; padding: 20px;'>\n";
echo "<h1>📞 Header Contact API Test</h1>\n\n";

// Configuration for Header Contact API
$apiBaseUrl = 'http://localhost:8000/api';
$configEndpoint = '/v1/header-contact';
$url = $apiBaseUrl . $configEndpoint;

echo "<h2>Testing API Endpoint:</h2>\n";
echo "<p><strong>URL:</strong> <a href='$url' target='_blank'>$url</a></p>\n\n";

// Test API connection
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($httpCode === 200) {
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<strong>✓ API responded successfully (HTTP $httpCode)</strong>";
    echo "</div>\n\n";
    
    $data = json_decode($response, true);
    if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
        echo "<h2>Current Header Contact Configuration:</h2>\n";
        echo "<table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>";
        echo "<tr style='background: #007bff; color: white;'>";
        echo "<th style='padding: 10px; text-align: left;'>Field</th>";
        echo "<th style='padding: 10px;'>Value</th>";
        echo "</tr>\n";
        
        $contact = $data['data'];
        $fields = [
            'Phone' => $contact['phone'] ?? 'N/A',
            'Email' => $contact['email'] ?? 'N/A',
            'Address' => $contact['address'] ?? 'N/A',
            'Facebook' => $contact['facebook'] ?? 'N/A',
            'Twitter' => $contact['twitter'] ?? 'N/A',
            'LinkedIn' => $contact['linkedin'] ?? 'N/A',
            'Instagram' => $contact['instagram'] ?? 'N/A',
            'YouTube' => $contact['youtube'] ?? 'N/A',
            'Active' => ($contact['is_active'] ?? false) ? 'Yes ✓' : 'No ✗',
        ];
        
        foreach ($fields as $label => $value) {
            echo "<tr style='border-bottom: 1px solid #ddd;'>";
            echo "<td style='padding: 10px; font-weight: bold;'>$label</td>";
            echo "<td style='padding: 10px;'>" . htmlspecialchars($value) . "</td>";
            echo "</tr>\n";
        }
        echo "</table>\n\n";
        
        // Display social links
        echo "<h2>Social Media Links:</h2>\n";
        echo "<div style='display: flex; gap: 15px; margin: 20px 0;'>\n";
        
        $socialIcons = [
            'Facebook' => ['icon' => 'fab fa-facebook-f', 'url' => $contact['facebook'] ?? '#'],
            'Twitter' => ['icon' => 'fab fa-twitter', 'url' => $contact['twitter'] ?? '#'],
            'LinkedIn' => ['icon' => 'fab fa-linkedin-in', 'url' => $contact['linkedin'] ?? '#'],
            'Instagram' => ['icon' => 'fab fa-instagram', 'url' => $contact['instagram'] ?? '#'],
            'YouTube' => ['icon' => 'fab fa-youtube', 'url' => $contact['youtube'] ?? '#'],
        ];
        
        foreach ($socialIcons as $name => $info) {
            if ($info['url'] && $info['url'] !== '#') {
                echo "<a href='" . htmlspecialchars($info['url']) . "' target='_blank' ";
                echo "style='display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; ";
                echo "background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>";
                echo "<i class='" . htmlspecialchars($info['icon']) . "'></i> $name";
                echo "</a>\n";
            }
        }
        echo "</div>\n\n";
        
    } else {
        echo "<div style='background: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
        echo "<strong>⚠ Invalid API response structure</strong>";
        echo "</div>\n\n";
        echo "<pre style='background: #f4f4f4; padding: 15px; overflow: auto;'>" . htmlspecialchars($response) . "</pre>\n";
    }
} else {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<strong>✗ API connection failed (HTTP $httpCode)</strong>";
    if ($error) {
        echo "<br>Error: $error";
    }
    echo "</div>\n\n";
    
    echo "<h3>Possible Solutions:</h3>\n";
    echo "<ol>\n";
    echo "<li>Make sure Laravel is running: <code>php artisan serve --host=0.0.0.0 --port=8000</code></li>\n";
    echo "<li>Check if the migration has been run: <code>php artisan migrate</code></li>\n";
    echo "<li>Verify there's at least one record in the header_contacts table</li>\n";
    echo "<li>Check Laravel logs: <code>storage/logs/laravel.log</code></li>\n";
    echo "</ol>\n";
}

echo "<h2>How to Add/Update Header Contact:</h2>\n";
echo "<ol>\n";
echo "<li>Go to Laravel admin panel</li>\n";
echo "<li>Navigate to Header Contact / Site Settings</li>\n";
echo "<li>Add phone, email, address, and social media links</li>\n";
echo "<li>Save the configuration</li>\n";
echo "<li>Refresh this page to see the changes</li>\n";
echo "</ol>\n\n";

echo "<h2>Raw API Response:</h2>\n";
echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; overflow: auto;'>";
echo htmlspecialchars($response);
echo "</pre>\n\n";

echo "</body>\n";
echo "</html>\n";
