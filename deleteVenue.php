<?php
  include('../connection.php');

  $id = $_POST['venueID'];

  $getVenue = $conn -> query("SELECT * FROM venue WHERE id='$id'");

  $venue_name = '';
  while($row = $getVenue -> fetch_array()){
    $venue_name = $row['name'];
  }

  $deleteSQL = $conn -> query("DELETE FROM venue WHERE id='$id'");

  if($deleteSQL){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'Venue: ' . $venue_name . ' was removed';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }

  $conn -> close();
?>