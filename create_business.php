<!DOCTYPE html>
<html>
<head>
    <title>Create Business</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,rgb(35, 32, 32),rgba(112, 101, 101, 0.64));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 350px;
            padding: 40px 30px;
            text-align: center;
            color: #fff;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        h3 {
            margin-bottom: 20px;
            color: #f8f9fa;
            font-weight: 300;
        }

        button {
            background: #4facfe;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            margin: 8px 0;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: #00c6ff;
            transform: translateY(-3px);
        }

        .back-home {
            background: #28a745;
        }

        .back-home:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Create Business</h2>
        <h3>Welcome</h3>
        <button onclick="location.href='agent.php'">Agent</button>
        <button onclick="location.href='hotel_business.php'">Hotel Business</button>
        <button class="back-home" onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </div>
</body>
</html>
