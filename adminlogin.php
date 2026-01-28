<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'gnc');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    // Fetch Admin from Database
    $sql = "SELECT * FROM admin WHERE admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        // Verify Password
        if (password_verify($admin_password, $admin['admin_password'])) {
            $_SESSION['admin'] = $admin_name;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
        }
    } else {
        echo "<script>alert('Admin Not Found!');</script>";
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
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            text-align: center;
            padding: 50px;
        }
        .login-container {
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

    <h2>Admin Login</h2>
    <div class="login-container">
        <form action="adminlogin.php" method="POST">
            <label>Admin Name:</label>
            <input type="text" name="admin_name" required>

            <label>Admin Password:</label>
            <input type="password" name="admin_password" required>

            <button type="submit" name="login">Login</button>
            <button onclick="location.href='admin_login.php'">Back to admin access</button>
        </form>
    </div>

</body>
</html>
