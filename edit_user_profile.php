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

// Fetch user data when username is provided
$userData = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_user'])) {
    $username = $_POST['username'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    $stmt->close();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $languages = $_POST['languages'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $bio = $_POST['bio'];

    $sql = "UPDATE users SET password=?, email=?, location=?, languages=?, skills=?, interests=?, bio=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $password, $email, $location, $languages, $skills, $interests, $bio, $username);

    if ($stmt->execute()) {
        echo "<script>alert('User profile updated successfully!'); window.location.href='edit_user_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
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
    <title>Edit User Profile</title>
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
            background: #28a745;
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
            background: #218838;
        }
        .back-btn {
            background: #007BFF;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Edit User Profile</h2>

    <div class="container">
        <!-- Form to Fetch User Data -->
        <form action="edit_user_profile.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username to Edit" required>
            <button type="submit" name="fetch_user">Fetch User</button>
        </form>

        <?php if ($userData): ?>
        <!-- Form to Update User Data -->
        <form action="edit_user_profile.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>">

            <input type="text" name="password" placeholder="New Password" value="<?php echo htmlspecialchars($userData['password']); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            <input type="text" name="location" placeholder="Location" value="<?php echo htmlspecialchars($userData['location']); ?>" required>
            <input type="text" name="languages" placeholder="Languages" value="<?php echo htmlspecialchars($userData['languages']); ?>" required>
            <input type="text" name="skills" placeholder="Skills" value="<?php echo htmlspecialchars($userData['skills']); ?>" required>
            <input type="text" name="interests" placeholder="Interests" value="<?php echo htmlspecialchars($userData['interests']); ?>" required>
            <textarea name="bio" placeholder="Bio" required><?php echo htmlspecialchars($userData['bio']); ?></textarea>

            <button type="submit" name="update_user">Update Profile</button>
        </form>
        <?php endif; ?>

        <button class="back-btn" onclick="location.href='edit_user.php'">Back to Edit Users</button>
    </div>

</body>
</html>
