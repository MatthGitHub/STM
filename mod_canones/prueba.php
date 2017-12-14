<?php
$con=mysqli_connect("localhost","root","cavaliere","my_db");
// Check connection

// Perform a query, check for error
if (!mysqli_query($con,"INSERT INTO Persons (FirstName) VALUES ('Glenn')"))
  {
  echo("Error description: " . mysqli_error($con));
  }

mysqli_close($con);
?>