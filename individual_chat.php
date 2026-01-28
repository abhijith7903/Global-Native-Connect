<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gnc");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$current_city = isset($_SESSION['current_city']) ? $_SESSION['current_city'] : '';
$selected_user = isset($_SESSION['selected_user']) ? $_SESSION['selected_user'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $timestamp = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO individual (username, message, current_city, selected_user,  created_at) 
            VALUES ('$username', '$message', '$current_city','$selected_user', '$timestamp')";
    $conn->query($sql);
}

$sql = "SELECT username, message, created_at FROM individual 
        WHERE (username='$username' AND selected_user='$selected_user') 
        OR (username='$selected_user' AND selected_user='$username') 
        ORDER BY created_at ASC";
$result = $conn->query($sql);

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .chat-box {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            border-bottom: 2px solid #007BFF;
        }
        .message {
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .sent {
            background: #007BFF;
            color: white;
            text-align: right;
        }
        .received {
            background: #e1e1e1;
            text-align: left;
        }
        .chat-form {
            display: flex;
            padding: 10px;
            background: #007BFF;
        }
        .chat-form input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        .chat-form button {
            padding: 10px 15px;
            background: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-box" id="chat-box">
            <?php foreach ($messages as $msg) { ?>
                <div class="message <?php echo ($msg['username'] == $username) ? 'sent' : 'received'; ?>">
                    <strong><?php echo $msg['username']; ?></strong><br>
                    <?php echo $msg['message']; ?><br>
                    <small><?php echo $msg['created_at']; ?></small>
                </div>
            <?php } ?>
        </div>
        <form class="chat-form" method="POST">
            <input type="text" name="message" placeholder="Type a message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>