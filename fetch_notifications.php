<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gnc");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    exit();
}

// Fetch user's current city
$username = $_SESSION['user'];
$user_query = $conn->prepare("SELECT current_city FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$current_city = $user['current_city'];

// Fetch latest messages for the user's city
$message_query = $conn->prepare("SELECT username, message, timestamp FROM messages WHERE current_city = ? ORDER BY timestamp DESC LIMIT 10");
$message_query->bind_param("s", $current_city);
$message_query->execute();
$result = $message_query->get_result();

// Display messages
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="notification-box">';
        echo '<strong>New message:</strong> ' . htmlspecialchars($row['message']) . '<br>';
        echo '<span class="timestamp">By ' . htmlspecialchars($row['username']) . ' | ' . $row['timestamp'] . '</span>';
        echo '</div>';
    }
} else {
    echo '<p>No new messages.</p>';
}

$conn->close();
?>
