<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #1e1e2f;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #2a2a3d;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }
        h2, h3 {
            color: #ccc;
        }
        button {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            border: none;
            padding: 12px 25px;
            margin: 10px 5px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
        }
        button:hover {
            background: linear-gradient(to right, #0056b3, #004085);
            transform: scale(1.05);
        }
        .back-home {
            background: linear-gradient(to right, #28a745, #1e7e34);
        }
        .back-home:hover {
            background: linear-gradient(to right, #1e7e34, #155d27);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>
        <h3>Welcome</h3>
        <button onclick="location.href='register.php'">Sign Up</button>
        <button onclick="location.href='login.php'">Login</button>
        <button class="back-home" onclick="location.href='home2.php'">Back to Home</button>
    </div>
</body>
</html>
