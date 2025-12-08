<?php
// Test script to verify upload paths

echo "Testing upload paths:\n";

// Check if directories exist
$cv_dir = 'eclatBack/back_office/storage/app/public/cvs/';
$lm_dir = 'eclatBack/back_office/storage/app/public/lettres_motivation/';

echo "CV directory exists: " . (file_exists($cv_dir) ? "YES" : "NO") . "\n";
echo "Cover letter directory exists: " . (file_exists($lm_dir) ? "YES" : "NO") . "\n";

// Test creating a file in CV directory
$test_cv = $cv_dir . 'test_cv.txt';
if (file_put_contents($test_cv, 'Test CV content')) {
    echo "Successfully created test CV file\n";
    unlink($test_cv); // Clean up
} else {
    echo "Failed to create test CV file\n";
}

// Test creating a file in cover letter directory
$test_lm = $lm_dir . 'test_letter.txt';
if (file_put_contents($test_lm, 'Test cover letter content')) {
    echo "Successfully created test cover letter file\n";
    unlink($test_lm); // Clean up
} else {
    echo "Failed to create test cover letter file\n";
}

echo "Test completed.\n";
?>