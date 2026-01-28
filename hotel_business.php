<?php
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_name = $conn->real_escape_string($_POST['hotel_name']);
    $city = $conn->real_escape_string($_POST['city']);
    $country = $conn->real_escape_string($_POST['country']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $website = $conn->real_escape_string($_POST['website']);

    if (empty($hotel_name) || empty($city) || empty($country) || empty($contact_number)) {
        $error_message = "All fields except website are required.";
    } else {
        $sql = "INSERT INTO business (hotel_name, city, country, contact_number, website) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $hotel_name, $city, $country, $contact_number, $website);
        
        if ($stmt->execute()) {
            $success_message = "Hotel registered successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Hotel</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: #ffffff;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: #1e1e1e;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            width: 40%;
            margin: auto;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h2 {
            color: #00bcd4;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #333;
            color: #fff;
            font-size: 16px;
        }
        input::placeholder {
            color: #999;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            color: #4caf50;
            font-weight: bold;
        }
        .error {
            color: #f44336;
            font-weight: bold;
        }
        .back-button {
            background: #ff5722;
            margin-top: 20px;
        }
        .back-button:hover {
            background: #e64a19;
        }
    </style>
</head>
<body>

    <h2>Register Your Hotel</h2>
    <div class="container">
        <?php if (!empty($success_message)) echo "<p class='message'>$success_message</p>"; ?>
        <?php if (!empty($error_message)) echo "<p class='error'>$error_message</p>"; ?>

        <form action="hotel_business.php" method="POST">
            <input type="text" name="hotel_name" placeholder="Hotel Name" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="country" placeholder="Country" required>
            <input type="text" name="contact_number" placeholder="Contact Number" required>
            <input type="url" name="website" placeholder="Website (Optional)">
            <button type="submit">Register Hotel</button>
        </form>
        <button class="back-button" onclick="window.location.href='create_business.php';">Back to Create Business</button>
    </div>

</body>
</html>
