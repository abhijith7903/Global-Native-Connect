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

// Handle adding a country
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_country'])) {
    $country = trim($_POST['country']);

    if (!empty($country)) {
        $sql = "INSERT INTO locations (country, cities, country_code) VALUES (?, '', '')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $country);

        if ($stmt->execute()) {
            $_SESSION['last_country_id'] = $stmt->insert_id; // Store last added country ID
            $_SESSION['last_country_name'] = $country;
            echo "<script>alert('Country added successfully! Now add cities and country code.');</script>";
        } else {
            echo "<script>alert('Error adding country!');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter a country!');</script>";
    }
}

// Handle adding cities and country code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cities'])) {
    $country_id = $_POST['country_id'];
    $cities = trim($_POST['cities']);
    $country_code = trim($_POST['country_code']);

    if (!empty($cities) && !empty($country_code) && !empty($country_id)) {
        $sql = "UPDATE locations SET cities = ?, country_code = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $cities, $country_code, $country_id);

        if ($stmt->execute()) {
            echo "<script>alert('Cities and country code added successfully!'); window.location.href='manage_locations.php';</script>";
        } else {
            echo "<script>alert('Error adding cities and country code!');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter cities and country code!');</script>";
    }
}

// Fetch countries and cities from the database
$sql = "SELECT * FROM locations ORDER BY id DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Locations</title>
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
            width: 50%;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <h2>Manage Locations</h2>

    <div class="container">
        <form action="manage_locations.php" method="POST">
            <input type="text" name="country" placeholder="Enter Country" required>
            <button type="submit" name="add_country">Add Country</button>
        </form>

        <!-- City Form (Only show if a country was just added) -->
        <?php if (isset($_SESSION['last_country_id'])): ?>
        <form action="manage_locations.php" method="POST">
            <input type="hidden" name="country_id" value="<?php echo $_SESSION['last_country_id']; ?>">
            <h3>Add Cities for <?php echo $_SESSION['last_country_name']; ?></h3>
            <input type="text" name="cities" placeholder="Enter Cities (comma-separated)" required>
            <input type="text" name="country_code" placeholder="Enter Country Code (e.g., US, IN, UK)" required>
            <button type="submit" name="add_cities">Add Cities & Country Code</button>
        </form>
        <?php 
            unset($_SESSION['last_country_id']); 
            unset($_SESSION['last_country_name']); 
        ?>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Country Code</th>
                <th>Cities</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['country']); ?></td>
                <td><?php echo !empty($row['country_code']) ? htmlspecialchars($row['country_code']) : 'No code added'; ?></td>
                <td><?php echo !empty($row['cities']) ? htmlspecialchars($row['cities']) : 'No cities added'; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <button class="back-btn" onclick="location.href='admin_dashboard.php'">Back to Dashboard</button>
        <button class="hotel-btn" onclick="location.href='hotel.php'">Hotel</button>
    </div>

</body>
</html>
