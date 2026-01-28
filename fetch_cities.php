

<?php
$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure country selection is provided
if (!isset($_POST['country']) || !isset($_POST['country_code']) || empty($_POST['country']) || empty($_POST['country_code'])) {
    die("No country selected. <a href='find_natives.php'>Go back</a>");
}

$country_name = $_POST['country'];
$country_code = $_POST['country_code'];

// Join `locations` and `hotels` tables on `country_code` and fetch distinct cities
$stmt = $conn->prepare("SELECT DISTINCT h.city FROM locations l JOIN hotels h ON l.country_code = h.country_code WHERE l.country_code = ? ORDER BY h.city ASC");
$stmt->bind_param("s", $country_code);
$stmt->execute();
$result = $stmt->get_result();

// Store cities in an array
$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row['city'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select City</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(255, 255, 255, 0.1);
            width: 50%;
            margin: auto;
        }
        h2 {
            color: #ffffff;
        }
        p {
            font-size: 18px;
            color: #bbbbbb;
        }
        select, button {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #444;
            border-radius: 5px;
            font-size: 16px;
            background: #333;
            color: white;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #218838;
        }
        .back-btn {
            background: #dc3545;
        }
        .back-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

    <h2>Select City</h2>

    <div class="container">
        <p><b>Country:</b> <?php echo htmlspecialchars($country_name); ?></p>
        <p><b>Country Code:</b> <?php echo htmlspecialchars($country_code); ?></p>

        <form action="natives.php" method="POST">
            <input type="hidden" name="country_name" value="<?php echo htmlspecialchars($country_name); ?>">
            <input type="hidden" name="country_code" value="<?php echo htmlspecialchars($country_code); ?>">

            <label for="city"><b>Select City:</b></label>
            <select id="city" name="city" required>
                <option value="">-- Select City --</option>
                <?php if (count($cities) > 0): ?>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?php echo htmlspecialchars($city); ?>">
                            <?php echo htmlspecialchars($city); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No cities available</option>
                <?php endif; ?>
            </select>

            <?php if (count($cities) > 0): ?>
                <button type="submit">Find Natives</button>
            <?php endif; ?>
        </form>
        <button class="back-btn" onclick="location.href='find_native.php'">Back to select country</button>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>