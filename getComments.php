<?php
  include('../connection.php');

  $eventID = $_GET['id'];

  $sql = "SELECT * FROM done WHERE id='$eventID'";
  $result = $conn -> query($sql);

  echo "<h4>Comments</h4>";

  while($row = $result -> fetch_array()){
    if($row['comments'] == 'None'){
      echo "<p>No comments to show.</p>";
    }else {
      $comments = json_decode($row['comments'], true);
      for($i = 0; $i < sizeof($comments); $i++){
        $photoURL = '';
        if($comments[$i]['name'] == 'Anonymous User'){
          $photoURL = '../asset/default.png';
        }else {
          $username = $comments[$i]['name'];
          $getPicture = $conn -> query("SELECT * FROM useraccounts WHERE username='$username'");
          while($getPic = $getPicture -> fetch_array()){
            $photoURL = $getPic['photoURL'];
          }
        }
        echo "
        <div class='comment mb-2'>
          <img class='col-3' src='../../client/".$photoURL."' />
          <div class='col comment-body'>
            <div class='comment-body-header'>
              <p class='commenter'>".$comments[$i]['name']."</p>
              <p class='comment-date'>".$comments[$i]['date']."</p>
            </div>
            <p>".$comments[$i]['message']."</p>
          </div>
        </div>  
        ";
      }
    }
  }

  $conn -> close();
?>