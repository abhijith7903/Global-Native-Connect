<?php
$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure required data is received
if (!isset($_POST['city']) || !isset($_POST['country_name']) || !isset($_POST['country_code'])) {
    die("Invalid access. <a href='fetch_cities.php'>Go back</a>");
}

$city = $_POST['city'];
$country_name = $_POST['country_name'];
$country_code = $_POST['country_code'];

// Fetch users who are in the selected city
$sql = "SELECT username, designation, mother_tongue, years_in_city, skills, interests 
        FROM users 
        WHERE current_city = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natives in <?php echo htmlspecialchars($city); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            text-align: center;
            padding: 20px;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
            width: 80%;
            margin: auto;
        }
        h2 {
            color: #ffffff;
        }
        .native-list {
            margin-top: 10px;
        }
        .native {
            background: #333333;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }
        .native strong {
            color: #00bcd4;
        }
        button {
            width: 80%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            color: white;
            background: linear-gradient(45deg, #007bff, #0056b3);
            transition: background 0.3s;
        }
        button:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
        }
        .btn-back {
            background: linear-gradient(45deg, #d9534f, #c82333);
        }
        .btn-back:hover {
            background: linear-gradient(45deg, #c82333, #a71d2a);
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h2>Welcome to <?php echo htmlspecialchars($city); ?>, <?php echo htmlspecialchars($country_name); ?>!</h2>

    <div class="container">
        <div class="left">
            <h3>People in <?php echo htmlspecialchars($city); ?></h3>
            <div class="native-list">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="native">
                            <strong><?php echo htmlspecialchars($row['username']); ?></strong><br>
                            <em><?php echo htmlspecialchars($row['designation']); ?></em><br>
                            <b>Mother Tongue:</b> <?php echo htmlspecialchars($row['mother_tongue']); ?><br>
                            <b>Years in City:</b> <?php echo htmlspecialchars($row['years_in_city']); ?><br>
                            <b>Skills:</b> <?php echo htmlspecialchars($row['skills']); ?><br>
                            <b>Interests:</b> <?php echo htmlspecialchars($row['interests']); ?><br>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No users found in <?php echo htmlspecialchars($city); ?>.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="right">
            <button onclick="window.location.href='chat_login.php?city=<?php echo urlencode($city); ?>'">Chat with Natives</button>
            <button onclick="window.location.href='book_stay.php?city=<?php echo urlencode($city); ?>'">Book My Stay</button>
            <button class="btn-back" onclick="window.location.href='find_native.php'">Back to Find Natives</button>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
