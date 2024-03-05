<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Appointments</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Booked Appointments</h1>
        
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
        $sql = "SELECT name, email, phone, date, start_time, end_time FROM bookings ORDER BY date, start_time";
        $result = $conn->query($sql);

        // display the results in a table
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered mt-4'>";
        echo "<thead class='thead-dark'><tr><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Start time</th><th>End time</th></tr></thead><tbody>";

        if ($result->num_rows > 0) {
          // output the data of each row
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td><td>" . $row["end_time"] . "</td></tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No bookings found</td></tr>";
        }

        echo "</tbody></table></div>";

        // close the database connection
        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
