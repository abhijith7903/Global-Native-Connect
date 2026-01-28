<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'gnc');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle File Upload
if (isset($_POST['upload'])) {
    $username = $_SESSION['user'];
    $file = $_FILES['file'];
    
    // Check if file is uploaded
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<script>alert('Please select a file to upload.');</script>";
    } else {
        $target_dir = "uploads/";
        $file_name = basename($file["name"]);
        $file_path = $target_dir . time() . "_" . $file_name; // Unique name
        $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
        $allowed_video = ['mp4', 'avi', 'mov', 'wmv'];

        if (in_array($file_type, $allowed_image)) {
            $post_type = 'image';
        } elseif (in_array($file_type, $allowed_video)) {
            $post_type = 'video';
        } else {
            echo "<script>alert('Invalid file type. Please upload an image or video.');</script>";
            exit();
        }

        // Move file & insert post data into database
        if (move_uploaded_file($file["tmp_name"], $file_path)) {
            $sql = "INSERT INTO posts (username, file_path, post_type) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $file_path, $post_type);
            if ($stmt->execute()) {
                echo "<script>alert('Post uploaded successfully!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Error uploading post.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error moving uploaded file.');</script>";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Post</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .post-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
            width: 50%;
        }

        h2 {
            color: #333;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 15px 30px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Create a Post</h2>
    <div class="post-container">
        <form action="post.php" method="POST" enctype="multipart/form-data">
            <label>Select Image or Video:</label>
            <input type="file" name="file" accept="image/*,video/*" required>
            <button type="submit" name="upload">Upload</button>
        </form>
        <button onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </div>

</body>
</html>
