<?php
  include('../connection.php');

  $sql = "SELECT * FROM done";
  $result = $conn -> query($sql);
  
  if($result -> num_rows == 0){
    echo "<p>No done event.</p>";
  }else {
    while($row = $result -> fetch_array()){
      echo "
        <a class='button is-small' id='".$row['id']."' onclick='viewComment(this.id)'>
          ".$row['client_name']."'s Event
        </a>
      ";
    }
  }

  $conn -> close();
?>