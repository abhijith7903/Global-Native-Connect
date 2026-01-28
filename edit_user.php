<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Users</title>
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
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            width: 100%;
        }
        button:hover {
            background: #0056b3;
        }
        .back-btn {
            background: #d9534f;
        }
        .back-btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>

    <h2>Edit Users</h2>
    
    <div class="container">
        <div class="btn-container">
            <button onclick="location.href='userlist.php'">Users</button>
            <button onclick="location.href='add_user.php'">Add User</button>
            <button onclick="location.href='delete_user.php'">Delete User</button>
            <button onclick="location.href='edit_user_profile.php'">Edit User Profile</button>
            <button class="back-btn" onclick="location.href='manage_user.php'">Back to Manage Users</button>
        </div>
    </div>

</body>
</html>
