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

// Fetch the user's current city
$username = $_SESSION['user'];
$user_query = $conn->prepare("SELECT current_city FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$current_city = $user['current_city'];

// Fetch hotels in the user's current city
$sql = "SELECT * FROM hotels WHERE city = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_city);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Stay</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            text-align: center;
            padding: 50px;
            color: white;
        }
        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            width: 80%;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.8);
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .book-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .book-btn:hover {
            background: #218838;
        }
        .no-hotels {
            color: #ffcc00;
            font-size: 18px;
            margin-top: 20px;
        }
        select, input {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Hotels Available in <?php echo htmlspecialchars($current_city); ?></h2>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Hotel Name</th>
                    <th>City</th>
                    <th>Luxury Levelof Room </th>
                    <th>Room Type</th>
                    <th>No. of People</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['hotel_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td>
                            <form action="book_now.php" method="post">
                                <input type="hidden" name="hotel_name" value="<?php echo htmlspecialchars($row['hotel_name']); ?>">
                                <input type="hidden" name="city" value="<?php echo htmlspecialchars($row['city']); ?>">
                                
                                <select name="luxury" required>
                                    <option value="5">5 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="1">1 Star</option>
                                </select>
                        </td>
                        <td>
                                <select name="room_type" required>
                                    <option value="Single Bed">Single Bed</option>
                                    <option value="Double Bed">Double Bed</option>
                                    <option value="Dormitory">Dormitory</option>
                                    <option value="Family Room">Family Room</option>
                                    <option value="Single Bed + AC">Single Bed + AC</option>
                                    <option value="Double Bed + AC">Double Bed + AC</option>
                                </select>
                        </td>
                        <td>
                            <input type="number" name="no_of_people" min="1" max="10" required>
                        </td>
                        <td>
                                <button type="submit"onclick="location.href='book_now.php'">Book Now</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No hotels available in your city.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
