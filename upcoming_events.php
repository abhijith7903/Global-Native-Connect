<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gnc");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$events = [];
$message = "";
$current_city = isset($_SESSION['current_city']) ? $_SESSION['current_city'] : '';

if (!empty($current_city)) {
    $query = "SELECT event_name, event_date, event_time, current_city, event_location FROM events WHERE current_city = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $current_city);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Correctly store multiple values in an array
        $events[] = [
            'name' => $row['event_name'],
            'date' => $row['event_date'],
            'time' => $row['event_time'],
            'location' => $row['event_location'],
            'city' => $row['current_city']
        ];
        
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #00c8ff;
        }

        .event-card {
            background: #282828;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            font-size: 16px;
            text-align: left;
            transition: transform 0.3s ease-in-out, background 0.3s;
        }

        .event-card:hover {
            transform: scale(1.05);
            background: #00c8ff;
            color: #121212;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            background: #00c8ff;
            color: #121212;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
            margin-top: 15px;
            display: block;
            width: 100%;
        }

        .btn:hover {
            background: #0094cc;
            transform: scale(1.05);
        }

        .message {
            font-size: 16px;
            margin-bottom: 10px;
            color: #f5a623;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Events in <?php echo htmlspecialchars($current_city); ?></h2>

        <?php if (!empty($events)) { ?>
            <ul>
                <?php foreach ($events as $event) { ?>
                    <li class="event-card">
                        <strong><?php echo htmlspecialchars($event['name']); ?></strong><br>
                        📅 Date: <?php echo htmlspecialchars($event['date']); ?><br>
                        ⏰ Time: <?php echo htmlspecialchars($event['time']); ?><br>
                        📍 Location: <?php echo htmlspecialchars($event['location']); ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p class="message">No events found.</p>
        <?php } ?>

        <a href="upcoming_login.php" class="btn">Back</a>
    </div>

</body>
</html>