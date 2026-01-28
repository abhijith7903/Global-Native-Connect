<?php
session_start();
include 'db_connection.php';

$username = $_SESSION['username'];
$sql = "SELECT current_city FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$current_city = $user['current_city'];

$query = "SELECT event_name FROM events WHERE city = ?";
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("s", $current_city);
$stmt2->execute();
$result2 = $stmt2->get_result();

$events = [];
while ($row = $result2->fetch_assoc()) {
    $events[] = $row['event_name'];
}

echo json_encode($events);
?>
