<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP Version: " . phpversion() . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "\nPOST data:\n";
    print_r($_POST);
    
    echo "\nFILES data:\n";
    print_r($_FILES);
    
    if (isset($_FILES['test_file'])) {
        $file = $_FILES['test_file'];
        echo "\nFile upload error: " . $file['error'] . "\n";
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/test/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $uploadPath = $uploadDir . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                echo "File successfully uploaded to: " . $uploadPath . "\n";
            } else {
                echo "Failed to move uploaded file\n";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="test_file">
        <button type="submit">Upload</button>
    </form>
</body>
</html> 