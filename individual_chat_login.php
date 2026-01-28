<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$users_list = [];
$success_message = "";
$error_message = "";

// Fetch users from users table who have the same current_city
$current_city = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $current_city = $conn->real_escape_string($_POST['current_city']);
    $selected_user = isset($_POST['selected_user']) ? $conn->real_escape_string($_POST['selected_user']) : '';

    if (!empty($selected_user)) {
        // Save user details to the individual table
        $sql = "INSERT INTO individual (username, current_city, selected_user) 
                VALUES ('$username', '$current_city', '$selected_user')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Chat session started successfully!";
            header("Location: individual_chat.php");
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

// Fetch user list based on current_city entered
if (!empty($_POST['current_city']) || !empty($_GET['current_city'])) {
    $current_city = isset($_POST['current_city']) ? $conn->real_escape_string($_POST['current_city']) : $conn->real_escape_string($_GET['current_city']);
    
    $query = "SELECT username FROM users WHERE current_city='$current_city'";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users_list[] = $row['username'];
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
    <title>Individual Chat Login</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f4037, #99f2c8);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            color: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin-bottom: 20px;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        input {
            background: rgba(255, 255, 255, 0.3);
            color: black;
            outline: none;
        }

        select {
            background: blue;
            color: white;
            cursor: pointer;
        }

        button {
            background: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }
    </style>
    <script>
        function fetchUsers() {
            let city = document.getElementById("current_city").value;
            if (city.trim() !== "") {
                fetch("individual_chat_login.php?current_city=" + city)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("selected_user").innerHTML = data;
                    });
            }
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>Individual Chat Login</h2>

        <?php if (!empty($success_message)) echo "<p class='message success'>$success_message</p>"; ?>
        <?php if (!empty($error_message)) echo "<p class='message error'>$error_message</p>"; ?>

        <form action="individual_chat_login.php" method="POST">
            <input type="text" name="username" placeholder="Enter your Username" required>
            <input type="text" name="current_city" id="current_city" placeholder="Enter your Current City" required onkeyup="fetchUsers()">

            <label for="selected_user">Select a User to Chat With:</label>
            <select name="selected_user" id="selected_user" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users_list as $user) { ?>
                    <option value="<?php echo $user; ?>" style="color:white;"> <?php echo $user; ?> </option>
                <?php } ?>
            </select>

            <button onclick="location.href='individual_chat.php'">Chat</button>
        </form>

        <button onclick="location.href='natives.php'">Back to Natives</button>
    </div>

</body>
</html>