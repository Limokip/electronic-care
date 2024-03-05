<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// check if the form is submitted
if (isset($_POST['submit'])) {
  // get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $issue = $_POST['issue'];
  $image = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];

  // validate the form data
  if (empty($name) || empty($email) || empty($issue)) {
    echo "Please fill all the fields";
  } else {
    // move the image to the uploads folder
    $image_path = "uploads/" . $image;
    move_uploaded_file($image_tmp, $image_path);

    // insert the data into the issues table
    $sql = "INSERT INTO issues (name, email, issue, image) VALUES ('$name', '$email', '$issue', '$image_path')";

    if ($conn->query($sql) === TRUE) {
      echo "Your issue has been submitted successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// close the connection
$conn->close();
?>

<!-- HTML form for the user -->
<!DOCTYPE html>
<html>
<head>
  <title>User Page</title>
  <!-- Bootstrap CSS CDN link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1 class="mt-5">Submit your issue</h1>
    <form action="services.php" method="post" enctype="multipart/form-data" class="mt-4">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="issue">Issue:</label>
        <textarea class="form-control" id="issue" name="issue" rows="5" cols="40"></textarea>
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control-file" id="image" name="image">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
  </div>

  <!-- Bootstrap JS and jQuery CDN links (optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
