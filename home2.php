<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Native Connect</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: black;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            backdrop-filter: brightness(0.7);
        }

        .container {
            background-color: rgba(77, 72, 72, 0.35);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 450px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2.8em;
            margin-bottom: 15px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 35px;
            color: #555;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            font-size: 1.1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.6);
        }

        .footer {
            margin-top: 40px;
            color: white;
            font-size: 0.9em;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Global Native Connect</h1>
        <p>Your gateway to exploring the world through local insights.</p>

        <a href="admin_login.php" class="button">Admin Login</a>
        <a href="user_login.php" class="button">User Login</a>
        <a href="index.php" class="button">Back to Index</a>

        <div class="footer">
            &copy; 2024 Global Native Connect. All rights reserved. | 
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a>
        </div>
    </div>
</body>
</html>
