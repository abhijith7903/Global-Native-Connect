<?php
$conn = new mysqli('localhost', 'root', '', 'gnc'); // Update DB credentials if needed

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM users ORDER BY years_in_city DESC";

$result = $conn->query($sql);

$usernames = [];
while ($row = $result->fetch_assoc()) {
    $usernames[] = $row['username'];
}

echo json_encode([
    'users' => $usernames
]);

$conn->close();
?>
