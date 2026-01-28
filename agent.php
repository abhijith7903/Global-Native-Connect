<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Agent Profile</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #fff;
            text-align: center;
            padding: 50px;
        }
        .register-container {
            background-color: #2b2b3d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.6);
            display: inline-block;
            text-align: left;
            width: 40%;
        }
        h2 {
            color: #f39c12;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input, textarea {
            background-color: #3a3a55;
            color: white;
        }
        button {
            background-color: #f39c12;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #e67e22;
        }
        .btn-back {
            background-color: #3498db;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Create Agent Profile</h2>
    <div class="register-container">
        <form action="agent.php" method="POST">
            <label>Agentname:</label>
            <input type="text" name="username" required />

            <label>Password:</label>
            <input type="password" name="password" required />

            <label>Email:</label>
            <input type="email" name="email" required />

            <label>Phone Number:</label>
            <input type="text" name="phone" required />

            <label>Current Designation:</label>
            <input type="text" name="designation" required />

            <label>Current Country:</label>
            <input type="text" name="current_country" required />

            <label>Current City:</label>
            <input type="text" name="current_city" required />

            <label>Mother Tongue:</label>
            <input type="text" name="mother_tongue" required />

            <label>No. of Years in City:</label>
            <input type="number" name="years_in_city" required min="0" />

            <label>Nationality:</label>
            <input type="text" name="location" required />

            <label>Languages:</label>
            <input type="text" name="languages" required />

            <label>Skills:</label>
            <input type="text" name="skills" required />

            <label>Interests:</label>
            <input type="text" name="interests" required />

            <label>Bio:</label>
            <textarea name="bio" required></textarea>

            <button type="submit" name="register">Register</button>
            <button class="btn-back" type="button" onclick="window.location.href='create_business.php';">Back to Create Business</button>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['register'])) {
    $conn = new mysqli('localhost', 'root', '', 'gnc');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $designation = $_POST['designation'];
    $current_country = $_POST['current_country'];
    $current_city = $_POST['current_city'];
    $mother_tongue = $_POST['mother_tongue'];
    $years_in_city = $_POST['years_in_city'];
    $location = $_POST['location'];
    $languages = $_POST['languages'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $bio = $_POST['bio'];

    $sql = "INSERT INTO users (username, password, email, phone, designation, current_country, current_city, mother_tongue, years_in_city, location, languages, skills, interests, bio) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssisssss", $username, $password, $email, $phone, $designation, $current_country, $current_city, $mother_tongue, $years_in_city, $location, $languages, $skills, $interests, $bio);

    if ($stmt->execute()) {
        header("Location: user_login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
