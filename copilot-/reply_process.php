<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contact');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['message_id']) && isset($_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $reply = $_POST['reply'];

    // Check if a record with the same message_id exists
    $check_sql = "SELECT * FROM admin_replies WHERE message_id = '$message_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        // Update existing record
        $update_sql = "UPDATE admin_replies SET reply = '$reply' WHERE message_id = '$message_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Reply updated successfully.";
        } else {
            echo "Error updating reply: " . $conn->error;
        }
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO admin_replies (message_id, reply) VALUES ('$message_id', '$reply')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Reply sent successfully.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
