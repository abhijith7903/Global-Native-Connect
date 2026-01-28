<?php
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['message' => 'You must be logged in to use the chatbot.']);
    exit();
}

include 'conn.php';
$email = $_SESSION['email'];

// Fetch user details
$query = "SELECT current_country, current_city FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$current_country = $user['current_country'];
$current_city = $user['current_city'];

// Get user input from JSON
$data = json_decode(file_get_contents('php://input'), true);
$option = $data['option'] ?? '';

if ($option === 'find_natives') {
    $sql = "SELECT username, years_in_city FROM users WHERE current_city = '$current_city'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $natives = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $natives[] = $row['username'] . ' (' . $row['years_in_city'] . ' years)';
        }
        echo json_encode(['message' => 'Natives in your city: ' . implode(', ', $natives)]);
    } else {
        echo json_encode(['message' => 'No natives found in your city.']);
    }
} else {
    echo json_encode(['message' => 'Invalid option selected.']);
}
?>
