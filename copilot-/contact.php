<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact";

// Create a connection object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection status
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$name = $email = $subject = $message = $feedback = "";
$name_err = $email_err = $subject_err = $message_err = $feedback_err = "";

// Process the form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter a subject.";
    } else {
        $subject = trim($_POST["subject"]);
    }

    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please enter a message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Validate feedback
    if (empty(trim($_POST["feedback"]))) {
        $feedback_err = "Please enter a feedback.";
    } else {
        $feedback = trim($_POST["feedback"]);
    }

    // Check for input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err) && empty($feedback_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO contact (name, email, subject, message, feedback) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_name, $param_email, $param_subject, $param_message, $param_feedback);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_subject = $subject;
            $param_message = $message;
            $param_feedback = $feedback;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to thank you page
                header("location: thank.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Link to Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <!-- Link to custom CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Create a container for the form -->
    <div class="container">
        <!-- Create a row for the form -->
        <div class="row">
            <!-- Create a column for the form -->
            <div class="col-md-12">
                <!-- Create a card for the form -->
                <div class="card">
                    <!-- Create a card header for the form -->
                    <div class="card-header">
                        <h3>Contact Us</h3>
                    </div>
                    <!-- Create a card body for the form -->
                    <div class="card-body">
                        <!-- Create a form for the inputs -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <!-- Create a form group for the name input -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="Enter your name" required>
                                <span class="invalid-feedback"><?php echo $name_err; ?></span>
                            </div>
                            <!-- Create a form group for the email input -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter your email" required>
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <!-- Create a form group for the subject input -->
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control <?php echo (!empty($subject_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subject; ?>" placeholder="Enter a subject" required>
                                <span class="invalid-feedback"><?php echo $subject_err; ?></span>
                            </div>
                            <!-- Create a form group for the message input -->
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" rows="5" placeholder="Enter a message" required><?php echo $message; ?></textarea>
                                <span class="invalid-feedback"><?php echo $message_err; ?></span>
                            </div>
                            <!-- Create a form group for the feedback input -->
                            <div class="form-group">
                                <label for="feedback">Feedback</label>
                                <select name="feedback" id="feedback" class="form-control <?php echo (!empty($feedback_err)) ? 'is-invalid' : ''; ?>" required>
                                    <option value="">Please select a feedback</option>
                                    <option value="Excellent" <?php echo ($feedback == "Excellent") ? "selected" : ""; ?>>Excellent</option>
                                    <option value="Good" <?php echo ($feedback == "Good") ? "selected" : ""; ?>>Good</option>
                                    <option value="Fair" <?php echo ($feedback == "Fair") ? "selected" : ""; ?>>Fair</option>
                                    <option value="Poor" <?php echo ($feedback == "Poor") ? "selected" : ""; ?>>Poor</option>
                                </select>
                                <span class="invalid-feedback"><?php echo $feedback_err; ?></span>
                            </div>
                            <!-- Create a button for the submit -->
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Link to jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Link to Bootstrap CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js"></script>
</body>
</html>
