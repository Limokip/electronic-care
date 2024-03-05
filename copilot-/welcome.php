<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Display user profile
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0pq8LyFfO65iLG7cNqJUrz4tPd0+DxUz3JrQ8HA0bj/eELZxZJ+pPKVNJHXmS" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        .profile-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
            <p>Your email is: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
            <!-- You can display more user information here -->
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-H5zP5GFPTIw1fIyA2UKmIxM7/w+3TCk6CDZvNU0AGbAix8hGRzrEyL0WVojJqNLa" crossorigin="anonymous"></script>
</body>
</html>
