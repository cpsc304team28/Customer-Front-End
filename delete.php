<?php

/**
  * Delete a user
  */

require "config.php";
require "common.php";

if (isset($_GET["CustomerID"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $CustomerID = $_GET["CustomerID"];

    $sql = "DELETE FROM Customer WHERE CustomerID = :CustomerID";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':CustomerID', $CustomerID);
    $statement->execute();

    $success = "User successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
else {
    $success = "User not Found";
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Customer";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete Customers</h2>

<?php if ($success) echo $success; ?>

<table class="blueTable">
  <thead>
    <tr>
    <th>ID #</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Address</th>
    <th>Credit Card</th>
    <th>Adults</th>
    <th>Children</th>
    <th>Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
        <td><?php echo escape($row["CustomerID"]); ?></td>
        <td><?php echo escape($row["Name"]); ?></td>
        <td><?php echo escape($row["PhoneNo"]); ?></td>
        <td><?php echo escape($row["Email"]); ?></td>
        <td><?php echo escape($row["Address"]); ?></td>
        <td><?php echo escape($row["CreditCard"]); ?></td>
        <td><?php echo escape($row["noOfAdults"]); ?> </td>
        <td><?php echo escape($row["noOfChildren"]); ?> </td>
      <td><a href="delete.php?CustomerID= <?php echo escape($row["CustomerID"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>