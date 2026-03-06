<?php
require_once __DIR__ . '/config.php';

echo "API Base URL: $apiBaseUrl\n";
echo "Site Title: " . getSiteTitle() . "\n";
echo "Logo URL: " . getLogoUrl() . "\n";
echo "Logo Alt: " . getLogoAlt() . "\n";
