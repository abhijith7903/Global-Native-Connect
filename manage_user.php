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
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        button {
            width: 100%;
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
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

    <h2>Manage Users</h2>
    <div class="container">
        <div class="btn-container">
            <button onclick="location.href='edit_user.php'">Edit Users</button>
            <button onclick="location.href='manage_messages.php'">Manage Messages</button>
            <button class="back-btn" onclick="location.href='admin_dashboard.php'">Back to Dashboard</button>
        </div>
    </div>

</body>
</html>
