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

    $sql = "SELECT *
    FROM Room
    WHERE RoomNo IN 
    (SELECT RoomNo 
    FROM Reservation_Makes
    WHERE CheckInDate NOT BETWEEN :CheckInDate and :CheckOutDate
    AND CheckOutDate NOT BETWEEN :CheckInDate and :CheckOutDate)";

    $CheckInDate = $_POST['CheckInDate'];
    $CheckOutDate = $_POST['CheckOutDate'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':CheckInDate', $CheckInDate, PDO::PARAM_STR);
    $statement->bindParam(':CheckOutDate', $CheckOutDate, PDO::PARAM_STR);
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
      <h2 style="color:white;">Available Rooms</h2>

      <table class="blueTable">
        <thead>
          <tr>
            <th>Room #</th>
            <th>Price</th>
            <th>Beds</th>
            <th>Kitchen</th>
            <th>Patio</th>
            <th>Accessible</th>
            <th>Private Pool</th>
            <th>Make Reservation</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row) { ?>
            <tr>
              <td><?php echo escape($row["RoomNo"]); ?></td>
              <td><?php echo escape($row["Price"]); ?></td>
              <td><?php echo escape($row["NoOfBeds"]); ?></td>
              <td><?php echo escape($row["Kitchen"]); ?></td>
              <td><?php echo escape($row["Patio"]); ?></td>
              <td><?php echo escape($row["Handicap"]); ?></td>
              <td><?php echo escape($row["PrivatePool"]); ?> </td>
              <td><a href="reserve.php?RoomNo= <?php echo escape($row["RoomNo"]); ?> &CheckInDate=<?php echo $CheckInDate; ?>&CheckOutDate=<?php echo $CheckOutDate; ?> &Price=<?php echo escape($row["Price"]); ?>">Reserve Now!</a> </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      > No results found for <?php echo escape($_POST['PhoneNo']); ?>.
    <?php }
  } ?>

  <!-- Form to enter customer information; submit calls SQL method up top -->
  <h2 style="color:white;">Dates</h2>
  <form method="post">
    <label for="CheckInDate">Check-in:</label>
    
    <input type="date" name="CheckInDate">
    <label for="CheckOutDate">Check-out:</label>

    <input type="date" name="CheckOutDate">
    <input type="submit" name="submit" value="View Results">
  </form>

  <a href="indexCustomerView.php">Back to home</a>

