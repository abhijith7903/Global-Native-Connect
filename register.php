<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #25273c);
            text-align: center;
            padding: 50px;
        }
        .register-container {
            background: grey;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
            width: 40%;
        }
        h2 {
            color: white;
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
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Sign Up</h2>
    <div class="register-container">
        <form action="register.php" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Phone Number:</label>
            <input type="text" name="phone" required>

            <label>Current Designation:</label>
            <input type="text" name="designation" required>

            <label>Current Country(for natives outside home country)/Country you wish to migrate or explore:</label>
            <input type="text" name="current_country" required>

            <label>City of the above country:</label>
            <input type="text" name="current_city" required>

            <label>Mother Tongue:</label>
            <input type="text" name="mother_tongue" required>

            <label>No. of Years in City:</label>
            <input type="number" name="years_in_city" required min="0">

            <label>Nationality:</label>
            <input type="text" name="location" required>
            
            <label>Languages Known:</label>
            <input type="text" name="languages" required>
            
            <label>Skills:</label>
            <input type="text" name="skills" required>
            
            <label>Interests:</label>
            <input type="text" name="interests" required>
            
            <label>Bio:</label>
            <textarea name="bio" required></textarea>
            
            <button type="submit" name="register">Register</button>
            <button class="back-button" onclick="location.href='user_login.php'">Back to User Login</button>
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
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
    
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
