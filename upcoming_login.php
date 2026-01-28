<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle city input and redirect to upcoming_events.php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['current_city'])) {
    $_SESSION['current_city'] = $_POST['current_city'];
    header("Location: upcoming_events.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f4037, #99f2c8);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            color: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }
        input {
            background: rgba(255, 255, 255, 0.3);
            color: black;
            outline: none;
        }
        button {
            background: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            font-weight: bold;
            margin-top: 10px;
            color: yellow;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Enter Your City</h2>

        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form action="upcoming_login.php" method="POST">
            <input type="text" name="current_city" placeholder="Enter your Current City" required>
            <button type="submit">Show Events</button>
        </form>
    </div>

</body>
</html>