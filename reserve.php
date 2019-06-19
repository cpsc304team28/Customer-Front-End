<?php
// Use an HTML form to edit an entry in the customers table.

require "config.php";
require "common.php";

// Similar to create.php submit form
if (isset($_POST['submit'])) {
  $new_ID = mt_rand(0,9999999);
  try {
    $connection = new PDO($dsn, $username, $password, $options);

      $new_user = array(
        "customerID"     => $new_ID,
        "name" => $_POST['name'],
        "phoneno"     => $_POST['phoneno'],
        "email"     => $_POST['email'],
        "address"   => $_POST['address'],
        "creditcard"    => $_POST['creditcard'],
        "NoOfAdults"    => $_POST['NoOfAdults'],
        "NoOfChildren"  => $_POST['NoOfChildren'],
      );

      // create an SQL statement to insert users input
      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Customer",
        implode(", ", array_keys($new_user)),
        ":" . implode(", :", array_keys($new_user))
      );

      // send the SQL to the server
      $statement = $connection->prepare($sql);
      $statement->execute($new_user);

      $new_res_ID = mt_rand(0,9999999);

      $new_res = array(
          "ReservationNo" => $new_res_ID,
          "RoomNo"     => $_GET['RoomNo'],
          "CustomerID"     => $new_ID,
          "CheckInDate"     => $_GET['CheckInDate'],
          "CheckOutDate"   => $_GET['CheckOutDate']
        );
    
      // create an SQL statement to insert users input
      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Reservation_Makes",
        implode(", ", array_keys($new_res)),
        ":" . implode(", :", array_keys($new_res))
      );
  
      // send the SQL to the server
      $statement = $connection->prepare($sql);
      $statement->execute($new_res);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

// Fetch customer tuple from given CustomerID, store it in $Customer
if (isset($_GET['RoomNo'])) {

  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $RoomNo = $_GET['RoomNo'];
    $sql = "SELECT Price FROM Room WHERE RoomNo = :RoomNo";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':RoomNo', $RoomNo);
    $statement->execute();
    $Price = $statement->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "No such room exists! Oops!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    Reservation Made. Confirmation sent to <?php echo escape($_POST['email']); ?> .
  <?php endif; ?>

  <h2 style="color:white;">Make Reservation</h2>

  <!-- Input form, don't allow editing of customerID -->
  <form method="post">
    <p class=paratext> Subtotal =
    <?php $Nights = intval(str_replace("-","",$_GET['CheckOutDate'])) - intval(str_replace("-","",$_GET['CheckInDate'])) ?> 
    <?php $Number = intval($_GET['Price']) * $Nights ?> 
    $<?php echo $Number ?>
    </p>
    
    <p style=paratext> Taxes = $<?php echo $Number * 0.15 ?> </p>

    <p style=paratext> Total for <?php echo $Nights ?> Nights = $<?php echo $Number * 0.15 + $Number ?> </p>

    <br/>

    <p style=paratext> Please fill in your information: </p>

    <label for="name">Name</label>
    <input type="text" name="name" id="name">

    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">

    <label for="phoneno">Phone</label>
    <input type="text" name="phoneno" id="phoneno">

    <label for="address">Address</label>
    <input type="text" name="address" id="address">

    <label for="creditcard">Credit Card</label>
    <input type="text" name="creditcard" id="creditcard">

    <label for="NoOfAdults">Number of Adults</label>
    <input type="text" name="NoOfAdults" id="NoOfAdults">

    <label for="NoOfChildren">Number of Children</label>
    <input type="text" name="NoOfChildren" id="NoOfChildren">

    <input type="submit" name="submit" value="Reserve Now">

  </form>

<a href="indexCustomerView.php">Back to home</a>
