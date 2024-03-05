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

// query the issues table
$sql = "SELECT * FROM issues";
$result = $conn->query($sql);

// close the connection
$conn->close();
?>

<!-- HTML table for the admin -->
<!DOCTYPE html>
<html>
<head>
  <title>Admin Page</title>
  <!-- Bootstrap CSS CDN link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1 class="mt-5">View the issues</h1>
    <div class="table-responsive mt-4">
      <table class="table table-striped table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Issue</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Loop through the result set and display the data
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>".$row["name"]."</td>";
              echo "<td>".$row["email"]."</td>";
              echo "<td>".$row["issue"]."</td>";
              echo "<td><img src='".$row["image"]."' width='100'></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No issues found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery CDN links (optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
