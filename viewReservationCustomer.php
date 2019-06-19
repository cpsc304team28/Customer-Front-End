<?php

  // Function to query information based on
  // a parameter: in this case, CustomerID.


// Send SQL statement to display customer with given customerID
$result = 0;
if (isset($_POST['submit'])) {
  try {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT ReservationNo, RoomNo, CheckInDate, CheckOutDate
    FROM Reservation_Makes
    WHERE CustomerID in (SELECT CustomerID FROM Customer WHERE phoneno = :phoneno)";

    $phoneno = $_POST['phoneno'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':phoneno', $phoneno, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<!-- Table to display the customer information -->
<?php require "templates/header.php"; ?>
  <?php
  if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
      <h2 style="color:white;">Results</h2>

      <table class="blueTable">
        <thead>
          <tr>
            <th>Reservation #</th>
            <th>Room #</th>
            <th>Cheeck-in</th>
            <th>Check-out</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row) { ?>
            <tr>
              <td><?php echo escape($row["ReservationNo"]); ?></td>
              <td><?php echo escape($row["RoomNo"]); ?></td>
              <td><?php echo escape($row["CheckInDate"]); ?></td>
              <td><?php echo escape($row["CheckOutDate"]); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      > No results found for <?php echo escape($_POST['PhoneNo']); ?>.
    <?php }
  } ?>

  <!-- Form to enter customer information; submit calls SQL method up top -->
  <h2 style="color:white;">View Reservation</h2>
  <form method="post">
    <label for="phoneno">Enter your phone number:</label>
    <input type="text" id="phoneno" name="phoneno">
    <input type="submit" name="submit" value="View Results">
  </form>

  <a href="indexCustomerView.php">Back to home</a>

