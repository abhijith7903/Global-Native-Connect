<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all cities from the locations table
$sql = "SELECT id, country, country_code, cities FROM locations";
$result = $conn->query($sql);

// Handle adding hotels
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_hotel'])) {
    $city = $_POST['city'];
    $hotel_name = trim($_POST['hotel_name']);

    if (!empty($city) && !empty($hotel_name)) {
        $stmt = $conn->prepare("INSERT INTO hotels (city, hotel_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $city, $hotel_name);
        
        if ($stmt->execute()) {
            echo "<script>alert('Hotel added successfully!'); window.location.href='hotel.php';</script>";
        } else {
            echo "<script>alert('Error adding hotel!');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter a hotel name!');</script>";
    }
}

// Fetch all hotels with country codes
$hotelsQuery = "
    SELECT h.id, h.city, h.hotel_name, l.country_code 
    FROM hotels h 
    JOIN locations l ON FIND_IN_SET(h.city, l.cities) > 0
";
$hotelsResult = $conn->query($hotelsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hotels</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        input {
            width: 70%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }
        button:hover {
            background: #218838;
        }
        .back-btn {
            background: #007BFF;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Manage Hotels</h2>

    <div class="container">
        <h3>Available Cities</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Country Code</th>
                <th>City</th>
                <th>Add Hotel</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $cities = explode(",", $row['cities']); // Convert comma-separated cities into an array
                    foreach ($cities as $city):
                        $city = trim($city);
                        if (!empty($city)):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['country']); ?></td>
                    <td><?php echo htmlspecialchars($row['country_code']); ?></td>
                    <td><?php echo htmlspecialchars($city); ?></td>
                    <td>
                        <form action="hotel.php" method="POST">
                            <input type="hidden" name="city" value="<?php echo htmlspecialchars($city); ?>">
                            <input type="text" name="hotel_name" placeholder="Enter Hotel Name" required>
                            <button type="submit" name="add_hotel">Add</button>
                        </form>
                    </td>
                </tr>
                <?php endif; endforeach; ?>
            <?php endwhile; ?>
        </table>

        <h3>Hotels List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Country Code</th>
                <th>City</th>
                <th>Hotel Name</th>
            </tr>
            <?php while ($hotel = $hotelsResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $hotel['id']; ?></td>
                <td><?php echo htmlspecialchars($hotel['country_code']); ?></td>
                <td><?php echo htmlspecialchars($hotel['city']); ?></td>
                <td><?php echo htmlspecialchars($hotel['hotel_name']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <button class="back-btn" onclick="location.href='manage_locations.php'">Back to Locations</button>
    </div>

</body>
</html>
