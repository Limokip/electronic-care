<?php
// Start the session
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact";

// Create a connection object
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection status
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Process the form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for input errors before fetching data from database
    if (empty($email_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session and save the user data to the session variables
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;

                            // Redirect to welcome page
                            header("location: welcome.php");
                        } else {
                            // Password is not valid, display an error message
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Email doesn't exist, display an error message
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                        <h3>Login</h3>
                    </div>
                    <!-- Create a card body for the form -->
                    <div class="card-body">
                        <!-- Create a form for the inputs -->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <!-- Create a form group for the email input -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter your email" required>
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <!-- Create a form group for the password input -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Enter your password" required>
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <!-- Create a form group for the remember me checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>
                            <!-- Create a button for the login submit -->
                            <button type="submit" name="login" id="login" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                    <!-- Create a card footer for the login form -->
                    <div class="card-footer">
                        <p>Don't have an account? <a href="signup.php" id="show-signup">Sign up here</a></p>
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
