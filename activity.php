<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Page</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928DAB);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
            color: #fff;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        button {
            background: #4facfe;
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: #00c6ff;
            transform: translateY(-3px);
        }

        button:active {
            background: #007bff;
            transform: translateY(1px);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Activity Page</h2>
        <div class="buttons">
            <button onclick="window.location.href='upcoming_login.php'">Upcoming Events</button>
            <button onclick="window.location.href='create_event.php'">Create Event</button>
            <button onclick="location.href='dashboard.php'">Back to Dashboard</button>
        </div>
    </div>

</body>
</html>
