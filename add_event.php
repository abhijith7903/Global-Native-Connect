<?php
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $event_name = $conn->real_escape_string($_POST['event_name']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $event_time = $conn->real_escape_string($_POST['event_time']);
    $current_city = $conn->real_escape_string($_POST['current_city']);

    // Insert event into the database
    $sql = "INSERT INTO events (username, event_name, event_date, event_time, current_city) 
            VALUES ('$username', '$event_name', '$event_date', '$event_time', '$current_city')";

    if ($conn->query($sql) === TRUE) {
        $message = "Event added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
            width: 50%;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input, button {
            width: 80%;
            padding: 12px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        input {
            background: rgba(255, 255, 255, 0.9);
            color: black;
        }
        button {
            background: #28a745;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #218838;
        }
        .message {
            margin-top: 15px;
            font-size: 18px;
            color: yellow;
        }
        .back-btn {
            background: #007BFF;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            border-radius: 5px;
            color: white;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Add Event</h2>
    <div class="container">
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="text" name="event_name" placeholder="Enter Event Name" required>
            <input type="date" name="event_date" required>
            <input type="time" name="event_time" required>
            <input type="text" name="current_city" placeholder="Enter City" required>
            <button type="submit">Add Event</button>
        </form>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <a href="manage_events.php" class="back-btn">Back to Events</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
