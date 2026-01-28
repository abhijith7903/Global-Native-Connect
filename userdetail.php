<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'gnc');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user's details
$username = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

unset($user['password']); // Exclude password from display

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928DAB);
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .user-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 700px;
            box-sizing: border-box;
            text-align: left;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        h2 {
            width: 100%;
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 26px;
        }

        .column {
            width: 48%;
        }

        .user-info {
            margin: 10px 0;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0);
            border-left: 4px solidrgba(79, 172, 254, 0.61);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .user-info strong {
            color:rgb(129, 194, 251);
        }

        .back-button {
            background: #4facfe;
            color: #ffffff;
            border: none;
            padding: 12px 25px;
            width: 100%;
            margin-top: 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: background 0.3s, transform 0.2s;
        }

        .back-button:hover {
            background: #00c6ff;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="user-container">
        <h2>User Details</h2>
        
        <div class="column">
            <?php
            $halfDetails = array_slice($user, 0, ceil(count($user) / 2), true);
            foreach ($halfDetails as $key => $value) {
                $label = ucfirst(str_replace('_', ' ', $key));
                $displayValue = !empty($value) ? htmlspecialchars($value) : "Not provided";
                echo "<p class='user-info'><strong>$label:</strong> $displayValue</p>";
            }
            ?>
        </div>

        <div class="column">
            <?php
            $remainingDetails = array_slice($user, ceil(count($user) / 2), null, true);
            foreach ($remainingDetails as $key => $value) {
                $label = ucfirst(str_replace('_', ' ', $key));
                $displayValue = !empty($value) ? htmlspecialchars($value) : "Not provided";
                echo "<p class='user-info'><strong>$label:</strong> $displayValue</p>";
            }
            ?>
        </div>

        <button class="back-button" onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </div>

</body>
</html>
