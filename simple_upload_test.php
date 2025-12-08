<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if uploads directory exists
    $upload_dir = 'uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Process file uploads
    if (isset($_FILES['test_file'])) {
        $filename = uniqid() . '_' . basename($_FILES['test_file']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['test_file']['tmp_name'], $target_file)) {
            echo "File uploaded successfully: " . $target_file;
        } else {
            echo "Error uploading file.";
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Upload Test</title>
</head>
<body>
    <h2>Test File Upload</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="test_file" required><br><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>