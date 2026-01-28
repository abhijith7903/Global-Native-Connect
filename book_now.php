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

// Fetch user details
$username = $_SESSION['user'];
$user_query = $conn->prepare("SELECT phone FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$phone = $user['phone'];

// Get booking details from the form
$hotel_name = trim($_POST['hotel_name'] ?? '');
$city = trim($_POST['city'] ?? '');
$no_of_people = trim($_POST['no_of_people'] ?? '');
$room_type = trim($_POST['room_type'] ?? '');
$luxury = trim($_POST['luxury'] ?? '');

// Validate other fields
if (empty($hotel_name) || empty($city) || empty($no_of_people) || empty($room_type)) {
    echo "<script>alert('Invalid input! Please fill all fields correctly.'); window.history.back();</script>";
    exit();
}

// Insert booking into the database (assuming `id` is auto-incremented)
$insert_booking = $conn->prepare("INSERT INTO bookings (city, hotel_name, no_of_people, room_type, luxury) VALUES (?, ?, ?, ?, ?)");
$insert_booking->bind_param("ssiss", $city, $hotel_name, $no_of_people, $room_type, $luxury);

if ($insert_booking->execute()) {
    echo "<script>alert('Booking successful!'); window.location.href='book_stay.php';</script>";
} else {
    echo "<script>alert('Booking failed! Please try again.'); window.history.back();</script>";
}

$conn->close();
?>
