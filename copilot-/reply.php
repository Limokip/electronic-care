<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reply</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Reply</h1>
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'contact');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch message details
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM messages WHERE id=$id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p class='font-weight-bold'>Message from: " . $row["user_id"] . "</p>";
                echo "<p>Message: " . $row["message"] . "</p>";
                
                // Form to reply to the message
                echo "<form method='post' action='reply_process.php'>";
                echo "<input type='hidden' name='message_id' value='" . $id . "'>";
                echo "<div class='form-group'>";
                echo "<label for='reply'>Reply:</label>";
                echo "<textarea name='reply' class='form-control' placeholder='Enter your reply' required></textarea>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Send Reply</button>";
                echo "</form>";
            } else {
                echo "<p>Message not found.</p>";
            }
        } else {
            echo "<p>Invalid request.</p>";
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
