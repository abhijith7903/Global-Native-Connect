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
            background-image: url('indeximg2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            backdrop-filter: brightness(0.7);
            position: relative;
        }

        h1 {
            color: white;
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .button {
            display: inline-block;
            padding: 15px 35px;
            font-size: 1.2em;
            color: #fff;
            background-image: linear-gradient(45deg,rgb(248, 5, 5),rgb(181, 13, 13));
            border: none;
            border-radius: 50px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5);
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
        }

        .button:hover {
            background-image: linear-gradient(45deg, #0056b3, #004080);
            transform: translateX(-50%) translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 123, 255, 0.7);
        }
    </style>
</head>
<body>
    <a href="home2.php" class="button">Start</a>
</body>
</html>
