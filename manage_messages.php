<?php
$conn = new mysqli("localhost", "root", "", "gnc");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $message_id = $_POST['message_id'];

    $delete_sql = "DELETE FROM messages WHERE message_id = ?";
    $stmt = $conn->prepare($delete_sql);

    // ✅ Corrected bind_param() with "i" for integer
    $stmt->bind_param("i", $message_id);

    if ($stmt->execute()) {
        $message = "Message deleted successfully!";
    } else {
        $message = "Error deleting message: " . $conn->error;
    }

    $stmt->close();
}

// Fetch all messages from the messages table
$sql = "SELECT * FROM messages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages</title>
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
    </style>
</head>
<body>

    <h2>Manage Messages</h2>
    <div class="container">
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Message</th>
                    <th>Timestamp</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['message_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                        <td><?php echo htmlspecialchars($row['current_city']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="message_id" value="<?php echo $row['message_id']; ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="message">No messages found.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
