<?php
  include('../connection.php');

  $sql = $conn -> query("SELECT * FROM feedbacks");
  while($row = $sql -> fetch_array()){
    $dateTime = new DateTime($row['date']);
    echo "
      <div class='card'>
        <div class='card-body'>
          <p class='card-title'>".$row['subject']."</p>
          <p class='card-subtitle text-body-secondary'>".$dateTime->format('F j, Y')."</p>
          <p class='card-text'>".$row['message']."</p>
        </div>
      </div>
    ";
  }
  $conn -> close();
?>