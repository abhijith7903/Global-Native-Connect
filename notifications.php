<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}

// Fetch the logged-in user's city
$username = $_SESSION['user'];
$user_query = $conn->prepare("SELECT current_city FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$current_city = $user['current_city'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 50%;
            margin: auto;
        }
        h2 {
            color: #bb86fc;
        }
        .notification-box {
            background-color: #333;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: left;
        }
        .timestamp {
            font-size: 12px;
            color: #b0b0b0;
        }
        button {
            background-color: #bb86fc;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #9d6bf0;
        }
    </style>
    <script>
        function fetchNotifications() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("notifications").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "fetch_notifications.php", true);
            xhr.send();
        }

        // Fetch notifications every 5 seconds
        setInterval(fetchNotifications, 5000);
        window.onload = fetchNotifications;
    </script>
</head>
<body>

    <h2>Notifications</h2>
    <div class="container">
        <div id="notifications">Loading...</div>
        
        <!-- Go to Chat Button -->
        <button onclick="window.location.href='chat.php?city=<?php echo urlencode($current_city); ?>'">Go to Chat</button>
        
        <!-- Back to Dashboard Button -->
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>

</body>
</html>
