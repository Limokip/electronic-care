<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'contact');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch messages from users
        $sql = "SELECT * FROM messages";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display messages
            echo "<h2>Messages from Users</h2>";
            echo "<div class='table-responsive'>";
            echo "<table class='table'>";
            echo "<thead class='thead-dark'>";
            echo "<tr><th>User</th><th>Message</th><th>Reply</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td><a href='reply.php?id=" . $row["id"] . "' class='btn btn-primary'>Reply</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No messages from users.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
