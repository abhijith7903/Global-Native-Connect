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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $languages = $_POST['languages'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $bio = $_POST['bio'];
    $designation = $_POST['designation'];
    $current_country = $_POST['current_country'];
    $current_city = $_POST['current_city'];
    $mother_tongue = $_POST['mother_tongue'];
    $years_in_city = $_POST['years_in_city'];

    $sql = "INSERT INTO users (username, password,phone, email, location, languages, skills, interests, bio,designation,current_country,current_city,mother_tongue,years_in_city) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssss", $username, $password,$phone, $email, $location, $languages, $skills, $interests, $bio,$designation,$current_country,$current_city,$mother_tongue,$years_in_city );

    if ($stmt->execute()) {
        echo "<script>alert('User added successfully!'); window.location.href='edit_user.php';</script>";
    } else {
        echo "<script>alert('Error adding user!');</script>";
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
    <title>Add User</title>
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
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
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
            background: #0056b3;
        }
        .back-btn {
            background: #d9534f;
        }
        .back-btn:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>

    <h2>Add New User</h2>

    <div class="container">
        <form action="add_user.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" placeholder="phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="text" name="languages" placeholder="Languages" required>
            <input type="text" name="skills" placeholder="Skills" required>
            <input type="text" name="interests" placeholder="Interests" required>
            <input type="text" name="designation" placeholder="designation" required>
            <input type="text" name="current_country" placeholder="current_country" required>
            <input type="text" name="current_city" placeholder="current_city" required>
            <input type="text" name="mother_tongue" placeholder="mother_tongue" required>
            <input type="text" name="years_in_city" placeholder="years_in_city" required>
            <textarea name="bio" placeholder="Bio" rows="4" required></textarea>
            <button type="submit">Add User</button>
        </form>
        
        <button class="back-btn" onclick="location.href='edit_user.php'">Back to Edit Users</button>
    </div>

</body>
</html>
