<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <link rel="stylesheet" href="chat_styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            display: flex;
            width: 80%;
            height: 80%;
            background: #1e1e2f;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
        }
        .users-list {
            width: 30%;
            background: #2a2a3c;
            padding: 20px;
            overflow-y: auto;
        }
        .chat-box {
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            background: #18181b;
            border-radius: 10px;
        }
        .message {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 10px;
            max-width: 70%;
        }
        .own-message {
            background: #007bff;
            color: white;
            align-self: flex-end;
        }
        .other-message {
            background: #444;
            color: white;
        }
        .message-username {
            font-size: 12px;
            font-weight: bold;
            color: #ccc;
        }
        .message-time {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }
        .message-box {
            display: flex;
            margin-top: 10px;
        }
        .message-box input {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #3b3b5a;
            color: #fff;
        }
        .message-box button, .back-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            margin-left: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .message-box button:hover, .back-button:hover {
            background: #0056b3;
        }
        .back-button {
            margin-top: 20px;
            background: #dc3545;
        }
        .back-button:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Users List -->
        <div class="users-list">
            <h3>Users in <?php echo htmlspecialchars($current_city); ?></h3>
            <ul>
                <?php while ($row = $resultUsers->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['username']); ?></li>
                <?php endwhile; ?>
            </ul>
            <button class="back-button" onclick="location.href='chat_login.php'">Back to Chat Login</button>
        </div>

        <!-- Chat Box -->
        <div class="chat-box">
            <h3>Welcome to <?php echo htmlspecialchars($current_city); ?> Chat</h3>
            <div class="chat-messages">
                <?php while ($row = $resultMessages->fetch_assoc()): ?>
                    <div class="message <?php echo ($row['username'] == $username) ? 'own-message' : 'other-message'; ?>">
                        <div class="message-username"> <?php echo htmlspecialchars($row['username']); ?> </div>
                        <div> <?php echo htmlspecialchars($row['message']); ?> </div>
                        <div class="message-time"> <?php echo date('h:i A', strtotime($row['timestamp'])); ?> </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Message Input -->
            <form method="POST" class="message-box">
                <input type="text" name="message" placeholder="Type a message..." required>
                <button type="submit" name="send">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'gnc');

if (!isset($_SESSION['username'])) {
    header("Location: chat_login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user details
$sqlUser = "SELECT current_city, mother_tongue FROM users WHERE username = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();

if (!$userData) {
    echo "User not found.";
    exit();
}

$current_city = $userData['current_city'];
$mother_tongue = $userData['mother_tongue'];

// Fetch users with the same `current_city` and `mother_tongue`
$sqlUsers = "SELECT username FROM users WHERE current_city = ? AND mother_tongue = ?";
$stmtUsers = $conn->prepare($sqlUsers);
$stmtUsers->bind_param("ss", $current_city, $mother_tongue);
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

// Handle message sending
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $sqlMessage = "INSERT INTO messages (username, message, timestamp, current_city) VALUES (?, ?, NOW(), ?)";
        $stmtMessage = $conn->prepare($sqlMessage);
        $stmtMessage->bind_param("sss", $username, $message, $current_city);
        $stmtMessage->execute();
    }
}

// Fetch chat messages for users with the same `current_city`
$sqlMessages = "SELECT username, message, timestamp FROM messages WHERE current_city = ? ORDER BY timestamp ASC";
$stmtMessages = $conn->prepare($sqlMessages);
$stmtMessages->bind_param("s", $current_city);
$stmtMessages->execute();
$resultMessages = $stmtMessages->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            display: flex;
            width: 80%;
            height: 80%;
            background: #2a2a3c;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            overflow: hidden;
        }
        .users-list {
            width: 30%;
            background: #3b3b5a;
            padding: 20px;
            overflow-y: auto;
        }
        .chat-box {
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            border-radius: 10px;
            background: #1e1e2f;
        }
        .message {
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            max-width: 60%;
        }
        .own-message {
            background: #007bff;
            color: white;
            align-self: flex-end;
        }
        .other-message {
            background: #444;
            color: white;
        }
        .message-username {
            font-size: 12px;
            font-weight: bold;
            color: #ccc;
        }
        .message-box {
            display: flex;
            margin-top: 10px;
        }
        .message-box input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #3b3b5a;
            color: #fff;
        }
        .message-box button, .back-button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .message-box button:hover, .back-button:hover {
            background: #0056b3;
        }
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Users List -->
        <div class="users-list">
            <h3>Users in <?php echo htmlspecialchars($current_city); ?></h3>
            <ul>
                <?php while ($row = $resultUsers->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['username']); ?></li>
                <?php endwhile; ?>
            </ul>
            <button class="back-button" onclick="location.href='chat_login.php'">Back to Chat Login</button>
        </div>

        <!-- Chat Box -->
        <div class="chat-box">
            <h3>Welcome to <?php echo htmlspecialchars($current_city); ?> Chat</h3>
            <div class="chat-messages">
                <?php while ($row = $resultMessages->fetch_assoc()): ?>
                    <div class="message <?php echo ($row['username'] == $username) ? 'own-message' : 'other-message'; ?>">
                        <div class="message-username"> <?php echo htmlspecialchars($row['username']); ?> </div>
                        <div> <?php echo htmlspecialchars($row['message']); ?> </div>
                        <div class="message-time" style="font-size: 10px; color: #ccc;">
                            <?php echo date('h:i A', strtotime($row['timestamp'])); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Message Input -->
            <form method="POST" class="message-box">
                <input type="text" name="message" placeholder="Type a message..." required>
                <button type="submit" name="send">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
