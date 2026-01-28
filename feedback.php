<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedback = $conn->real_escape_string($_POST['feedback']);
    $stars = isset($_POST['stars']) ? intval($_POST['stars']) : 0;

    $sql = "INSERT INTO feedback (name, email, feedback, stars) VALUES ('$name', '$email', '$feedback', '$stars')";
    
    if ($conn->query($sql) === TRUE) {
        $success_message = "Thank you for your feedback!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1f4037, #99f2c8);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            color: #fff;
            text-align: center;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            outline: none;
        }

        textarea {
            height: 80px;
        }

        .stars {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .star {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s;
        }

        .star:hover,
        .star.selected {
            color: gold;
            transform: scale(1.2);
        }

        .message {
            color: #28a745;
            font-weight: bold;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
        }

        button {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 12px 30px;
            width: 100%;
            margin-top: 15px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }

        .back-button {
            background: #28a745;
            margin-top: 10px;
        }

        .back-button:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Feedback Form</h2>

        <?php if (isset($success_message)) echo "<p class='message'>$success_message</p>"; ?>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>

        <form action="feedback.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="feedback" placeholder="Your Feedback" required></textarea>

            <div class="stars">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" name="stars" id="starsInput" value="0">

            <button type="submit">Submit Feedback</button>
        </form>

        <button class="back-button" onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </div>

    <script>
        const stars = document.querySelectorAll(".star");
        const starsInput = document.getElementById("starsInput");

        stars.forEach(star => {
            star.addEventListener("click", function() {
                const value = this.getAttribute("data-value");
                starsInput.value = value;

                // Reset all stars
                stars.forEach(s => s.classList.remove("selected"));

                // Highlight selected stars
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add("selected");
                }
            });
        });
    </script>
</body>
</html>
