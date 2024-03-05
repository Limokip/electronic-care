<?php
class AdminPage {
    private $db;

    public function __construct() {
        // Connect to your XAMPP database here
        $this->db = new PDO('mysql:host=localhost;dbname=contact', 'root', '');
    }

    public function getIssues() {
        $stmt = $this->db->query("SELECT * FROM issues");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessages() {
        $stmt = $this->db->query("SELECT * FROM messages");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeedback() {
        $stmt = $this->db->query("SELECT * FROM contact");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$adminPage = new AdminPage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <title>Admin Page</title>
</head>
<body>
    <div class="container">
        <h1>My First Bootstrap Page</h1>
        <p>Resize this responsive page to see the effect!</p>
        <div class="row">
            <div class="col-sm-4">
                <h3>Issues</h3>
                <?php
                // Fetch issues
                $issues = $adminPage->getIssues();
                foreach ($issues as $issue) {
                    echo "Issue: " . $issue['issue'] . "<br>";
                }
                ?>
            </div>
            <div class="col-sm-4">
                <h3>Messages</h3>
                <?php
                // Fetch messages
                $messages = $adminPage->getMessages();
                foreach ($messages as $message) {
                    echo "Message: " . $message['message'] . "<br>";
                }
                ?>
            </div>
            <div class="col-sm-4">
                <h3>Feedback</h3>
                <?php
                // Fetch feedback
                $feedbacks = $adminPage->getFeedback();
                foreach ($feedbacks as $feedback) {
                    echo "Feedback: " . $feedback['feedback'] . "<br>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
