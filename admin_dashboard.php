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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            text-align: center;
            padding: 50px;
        }
        .dashboard-container {
            background: grey;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        h2 {
            color: white;
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
        .logout-btn {
            background: #d9534f;
        }
        .logout-btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>

    <h2>Admin Dashboard</h2>
    <div class="dashboard-container">
        <div class="btn-container">
            <button onclick="location.href='manage_user.php'">Manage Users</button>
            <button onclick="location.href='manage_events.php'">Manage Events</button>
            <button onclick="location.href='manage_locations.php'">Manage Locations</button>
            <button onclick="location.href='manage_hotel_business.php'">Manage Hotel Business</button>
            <button onclick="location.href='manage_feedback.php'">Manage Feedback</button>
            <button class="logout-btn" onclick="location.href='adminlogin.php'">Back to admin login</button>
        </div>
    </div>

</body>
</html>            
