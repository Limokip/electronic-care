<?php
class ChatSystem {
    public $mysqli;

    public function __construct() {
        // Connect to your existing 'contact' database here
        $this->mysqli = new mysqli('localhost', 'root', '', 'contact');
    }

    public function sendMessage($userId, $message) {
        $stmt = $this->mysqli->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $message);
        $stmt->execute();
    }

    public function getMessages() {
        $result = $this->mysqli->query("SELECT * FROM messages ORDER BY id ASC");
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        
        // Fetch and attach admin replies for each message
        foreach ($messages as &$message) {
            $stmt = $this->mysqli->prepare("SELECT reply FROM admin_replies WHERE message_id = ?");
            $stmt->bind_param("i", $message['id']);
            $stmt->execute();
            $admin_reply = $stmt->get_result()->fetch_assoc();
            if ($admin_reply) {
                $message['admin_reply'] = $admin_reply['reply'];
            } else {
                $message['admin_reply'] = null;
            }
        }
        
        return $messages;
    }
}

// Create an instance of the ChatSystem class
$chatSystem = new ChatSystem();

// Check if form is submitted for sending message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sendMessage'])) {
    $userId = $_POST['userId'];
    $message = $_POST['message'];
    $chatSystem->sendMessage($userId, $message);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Chat System</h1>

        <!-- Form for sending message -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-3">
            <h2>Send Message</h2>
            <input type="hidden" name="userId" value="1">
            <div class="form-group">
                <textarea name="message" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" name="sendMessage" class="btn btn-primary">Send Message</button>
        </form>

        <hr>

        <!-- Display messages -->
        <h2>Messages</h2>
        <div class="messages">
            <?php
            $messages = $chatSystem->getMessages();
            foreach ($messages as $message) {
                echo "<div class='message'>";
                echo "<p>User: " . $message['message'] . "</p>";
                if ($message['admin_reply']) {
                    echo "<p>Admin Reply: " . $message['admin_reply'] . "</p>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
