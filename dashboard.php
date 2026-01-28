<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
         body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #25273c);
            color: white;
            text-align: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dashboard-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            width: 350px;
        }
        h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        button:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }
        .icon-btn {
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .icon-btn img {
            width: 40px;
            height: 40px;
            filter: drop-shadow(0 0 5px white);
            transition: 0.3s;
        }
        .icon-btn img:hover {
            transform: scale(1.1);
        }
        .top-left, .top-right, .bottom-right {
            position: absolute;
            padding: 10px;
        }
        .top-left { left: 10px; top: 10px; }
        .top-right { right: 10px; top: 10px; }
        .bottom-right { right: 10px; bottom: 10px; }
    </style>
</head>
<body>

    <!-- About Us Icon (Top Left) -->
    <div class="top-left">
        <button class="icon-btn" onclick="location.href='aboutus.php'">
        <img src="about-us.jpg" alt="About us">  
        </button>
    </div>

    <!-- User Detail Icon (Top Right) -->
    <div class="top-right">
        <button class="icon-btn" onclick="location.href='userdetail.php'">
            <img src="user-icon.png" alt="User Detail">
        </button>
    </div>
   
    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>

        <div class="buttons">
            <button onclick="location.href='notifications.php'">Notifications</button>
            <button onclick="location.href='find_native.php'">Find Native</button>
            <button onclick="location.href='activity.php'">Activities/Events</button>
            <button onclick="location.href='create_business.php'">Create Business</button>
            <button onclick="location.href='user_login.php'">Back to User Login</button>
            <button onclick="location.href='feedback.php'">Feedback</button> 
        </div>
    </div>

    <!-- Chatbot Icon (Bottom Right) -->
    <div class="bottom-right">
        <button class="icon-btn" onclick="location.href='chat_frontend.html'">
            <img src="chatbot-icon.png" alt="Chatbot">
        </button>
    </div>

</body>
</html> 