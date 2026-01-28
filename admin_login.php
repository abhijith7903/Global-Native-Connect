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
            padding: 100px;
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

    <h2>Admin Access</h2>
    <div class="login-container">
        <button onclick="location.href='adminregister.php'">Sign Up</button>
        <button onclick="location.href='adminlogin.php'">Login</button>
        <button class="logout-btn" onclick="location.href='home2.php'">Back to home</button>
    </div>

</body>
</html>
