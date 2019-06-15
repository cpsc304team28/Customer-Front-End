<?php

/**
  * Use an HTML form to create a new entry in the
  * Customer table.
  *
  */


if (isset($_POST['submit'])) {
  require "config.php";
  require "common.php";

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = array(
      "customerID"     => $_POST['phoneno'],
      "name" => $_POST['name'],
      "phoneno"     => $_POST['phoneno'],
      "email"     => $_POST['email'],
      "address"   => $_POST['address'],
      "creditcard"    => $_POST['creditcard'],
      "noOfAdults"    => $_POST['noOfAdults'],
      "noOfChildren"  => $_POST['noOfChildren'],


    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"Customer",
implode(", ", array_keys($new_user)),
":" . implode(", :", array_keys($new_user))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}
?>



<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  > <?php echo $_POST['name']; ?> successfully added.
<?php } ?>

<h2>Sign-up</h2>

<form method="post">

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

        <label for="noOfAdults">Number of Adults</label>
    	<input type="text" name="noOfAdults" id="noOfAdults">

        <label for="noOfChildren">Number of Children</label>
    	<input type="text" name="noOfChildren" id="noOfChildren">

    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>
    
    <?php include "templates/footer.php"; ?>