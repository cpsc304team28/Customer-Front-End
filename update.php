<?php

/**
  * List all Customers with a link to edit
  */

try {
  require "config.php";
  require "common.php";

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

<h2>Update Customers</h2>

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
            <td><a href="update-single.php?customerID= <?php echo escape($row["CustomerID"]); ?>">Edit</a> </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>