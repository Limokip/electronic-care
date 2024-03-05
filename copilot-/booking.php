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

// get the user input from the form
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $date = $_POST['date'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];

  // validate the user input
  if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($start_time) || empty($end_time)) {
    echo "Please fill all the fields.";
  } else {
    // check if the date and time are available
    $sql = "SELECT * FROM bookings WHERE date = '$date' AND ((start_time <= '$start_time' AND end_time > '$start_time') OR (start_time < '$end_time' AND end_time >= '$end_time'))";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "Sorry, this slot is already booked. Please choose another one.";
      // do not add to database and do not display on the booked sessions table
    } else {
      // insert the booking into the database
      $sql = "INSERT INTO bookings (name, email, phone, date, start_time, end_time) VALUES ('$name', '$email', '$phone', '$date', '$start_time', '$end_time')";
      if ($conn->query($sql) === TRUE) {
        echo "Your booking has been confirmed. Thank you.";
        // display on the booked sessions table
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
}

// close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book an appointment</title>
  <!-- add bootstrap CDN links -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <h1>Book an appointment with the technician</h1>
    <form action="" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
      </div>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date" placeholder="Select a date">
      </div>
      <div class="form-group">
        <label for="start_time">Start time</label>
        <input type="time" class="form-control" id="start_time" name="start_time" placeholder="Select a start time">
      </div>
      <div class="form-group">
        <label for="end_time">End time</label>
        <input type="time" class="form-control" id="end_time" name="end_time" placeholder="Select an end time">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Book now</button>
    </form>
    <!-- move the small table to the bottom of the form -->
    <div class="mt-3">
      <h3>Booked sessions</h3>
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Start time</th>
            <th>End time</th>
          </tr>
        </thead>
        <tbody>
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

          // query the database for the booked sessions
          $sql = "SELECT date, start_time, end_time FROM bookings ORDER BY date, start_time";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // output the data of each row
            while($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td><td>" . $row["end_time"] . "</td></tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No bookings found</td></tr>";
          }

          // close the database connection
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
```.