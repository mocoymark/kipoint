<?php
  include('../connection.php');

  $client_name = $_GET['name'];

  $sql = "SELECT * FROM done WHERE starting_date='$client_name'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      request ID: ".$row['requestID']."
      starting_data: ".$row['starting_date']."
    ";
  }

  $conn -> close();
?>