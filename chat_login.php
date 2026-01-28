<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $current_city = trim($_POST['current_city']);

    if (!empty($username) && !empty($current_city)) {
        // Check if user exists in the database
        $sql = "SELECT * FROM users WHERE username = ? AND current_city = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $current_city);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists - store in session and redirect to chat
            $_SESSION['username'] = $username;
            $_SESSION['current_city'] = $current_city;
            header("Location: chat.php");
            exit();
        } else {
            $error_message = "Invalid credentials. Please check your details.";
        }
    } else {
        $error_message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .login-container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #333;
            color: white;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: #ff4d4d;
            margin-top: 10px;
        }
        .back-btn {
            background-color: #555;
        }
        .back-btn:hover {
            background-color: #777;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login to Chat</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="text" name="current_city" placeholder="Enter Current City" required>
            <button type="submit">Go to Chat</button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <button class="back-btn" onclick="location.href='natives.php'">Back to Natives</button>
    </div>

</body>
</html>
