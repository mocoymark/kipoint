<?php
  include('../connection.php');
  
  $userID = $_GET['id'];

  $sql = $conn -> query("SELECT * FROM useraccounts WHERE id='$userID'");


  while($row = $sql -> fetch_array()){
    echo "
      <div class='offcanvas-header'>
        <h5 class='offcanvas-title' id='offcanvasRight'>".$row['fullname']."</h5>
        <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
      </div>
      <div class='offcanvas-body userbody-canvas'>
        <p>Contact: ".$row['contact_number']."</p>
        <p>Age: ".$row['age']."</p>
        <p>Birthday: ".$row['birthdate']."</p>
        <p>Address: ".$row['complete_address']."</p>
        <p>Current Request: ".$row['requestID']."</p>
      </div>
    ";
  }

  $conn -> close();
?>