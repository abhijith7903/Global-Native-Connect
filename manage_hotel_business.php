<?php
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $business_id = $_POST['business_id'];

    $delete_sql = "DELETE FROM business WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $business_id);

    if ($stmt->execute()) {
        $message = "Business deleted successfully!";
    } else {
        $message = "Error deleting business: " . $conn->error;
    }
}

// Fetch all hotel businesses from the business table
$sql = "SELECT * FROM business";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hotel Business</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            text-align: center;
            padding: 50px;
            color: white;
        }
        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            width: 80%;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.8);
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .message {
            margin-top: 15px;
            font-size: 18px;
            color: yellow;
        }
        .back-btn {
            background: #007BFF;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            border-radius: 5px;
            color: white;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Manage Hotel Business</h2>
    <div class="container">
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Hotel Name</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Contact Number</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['hotel_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><?php echo htmlspecialchars($row['country']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank">
                            <?php echo htmlspecialchars($row['website']); ?></a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="business_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="message">No hotel businesses found.</p>
        <?php endif; ?>

        <a href="hotel_business.php" class="back-btn">Add New Business</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
