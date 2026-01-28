<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Native</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right,rgb(22, 21, 21),rgba(18, 17, 17, 0.73));
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        h2 {
            color: #007bff;
            font-weight: 600;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select, button {
            width: calc(100% - 20px);
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
        }

        select {
            background-color: #f5f5f5;
            color: #333;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-top: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-btn {
            background-color: #6c757d;
            margin-top: 12px;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        @media (max-width: 500px) {
            .container {
                width: 90%;
            }
        }
    </style>
    <script>
        function updateCountryCode() {
            var countrySelect = document.getElementById("country");
            var countryCodeInput = document.getElementById("country_code");

            var selectedOption = countrySelect.options[countrySelect.selectedIndex];
            countryCodeInput.value = selectedOption.getAttribute("data-code");
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>Find Your Native Community</h2>

        <form action="fetch_cities.php" method="POST">
            <label for="country">Select Country</label>
            <select id="country" name="country" onchange="updateCountryCode()" required>
                <option value="">-- Select Country --</option>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'gnc');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $countries_query = "SELECT DISTINCT country, country_code FROM locations ORDER BY country ASC";
                $countries_result = $conn->query($countries_query);
                while ($row = $countries_result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['country']); ?>" 
                            data-code="<?php echo htmlspecialchars($row['country_code']); ?>">
                        <?php echo htmlspecialchars($row['country']); ?>
                    </option>
                <?php endwhile; ?>
                <?php $conn->close(); ?>
            </select>

            <input type="hidden" id="country_code" name="country_code">
            <button type="submit">Select City</button>
        </form>

        <button class="back-btn" onclick="location.href='dashboard.php'">Back to Dashboard</button>
    </div>

</body>
</html>
