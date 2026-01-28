<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $username = $_POST['username'];

    // Check if user exists
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $delete_sql = "DELETE FROM users WHERE username = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("s", $username);
        if ($stmt_delete->execute()) {
            echo "<script>alert('User deleted successfully!'); window.location.href='delete_user.php';</script>";
        } else {
            echo "<script>alert('Error deleting user!');</script>";
        }
        $stmt_delete->close();
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background: #c82333;
        }
        .back-btn {
            background: #007BFF;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Delete User</h2>

    <div class="container">
        <form action="delete_user.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username to Delete" required>
            <button type="submit" name="delete_user">Delete User</button>
        </form>
        
        <button class="back-btn" onclick="location.href='edit_user.php'">Back to Edit Users</button>
    </div>

</body>
</html>
