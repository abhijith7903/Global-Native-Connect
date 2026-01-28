<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);
    $admin_number = $_POST['admin_number'];

    // Insert Admin into Database
    $sql = "INSERT INTO admin (admin_name, admin_password, admin_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $admin_name, $admin_password, $admin_number);

    if ($stmt->execute()) {
        echo "<script>alert('Admin Registered Successfully!'); window.location='admin_login.php';</script>";
    } else {
        echo "<script>alert('Registration Failed!');</script>";
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
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            text-align: center;
            padding: 50px;
        }
        .register-container {
            background: grey;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 350px;
            margin: auto;
        }
        h2 {
            color: white;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Admin Registration</h2>
    <div class="register-container">
        <form action="adminregister.php" method="POST">
            <label>Admin Name:</label>
            <input type="text" name="admin_name" required>

            <label>Admin Password:</label>
            <input type="password" name="admin_password" required>

            <label>Admin Number:</label>
            <input type="text" name="admin_number" required>

            <button type="submit" name="register">Register</button>
            <button class="logout-btn" onclick="location.href='admin_login.php'">Back to admin access</button>
        </form>
    </div>

</body>
</html>
