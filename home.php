<!DOCTYPE html>
<html>
<head>
    <title>Global Native Connect</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h2 {
            color: #333;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
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
    <h2>Global Native Connect</h2>
    <div class="login-container">
        <h3>Login</h3>
        <button onclick="location.href='user_login.php'">User Login</button>
        <button onclick="location.href='admin_login.php'">Admin Login</button>
    </div>
</body>
</html>
