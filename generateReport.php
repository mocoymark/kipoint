<?php
  require "../../vendor/autoload.php";
  use Dompdf\Dompdf;

  $dompdf = new Dompdf();
  include('../connection.php');

  $param = $_GET['selector'];

  $sql = "SELECT * FROM $param";
  $result = $conn -> query($sql);
  $html = '';
  $title = '';
  
  if($param == 'useraccounts'){
    $title = '<h4>List of User Accounts</h4>';

    $html .= "
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Contact Number</th>
          <th>Status</th>
        </tr>
      ";

    while($row = $result -> fetch_array()){
      $html .= "
        <tr>
          <td>".$row['fullname']."</td>
          <td>".$row['username']."</td>
          <td>".$row['email']."</td>
          <td>".$row['contact_number']."</td>
          <td>".$row['status']."</td>
        </tr>
      ";
    }
  }elseif ($param == 'inventory') {
    $title = '<h4>List of Inventory</h4>';

    $html .= "
        <tr>
          <th>Name</th>
          <th>Serial Code</th>
          <th>Brand</th>
          <th>Category</th>
          <th>Quantity</th>
          <th>In Reserve</th>
          <th>Available</th>
        </tr>
      ";

    while($row = $result -> fetch_array()){
      $html .= "
        <tr>
          <td>".$row['name']."</td>
          <td>".$row['serial_code']."</td>
          <td>".$row['brand']."</td>
          <td>".$row['category']."</td>
          <td>".$row['quantity']."</td>
          <td>".$row['in_reserve']."</td>
          <td>".$row['available']."</td>
        </tr>
      ";
    }
  }elseif ($param == 'venue') {
    $title = '<h4>List of Venues</h4>';

    $html .= "
        <tr>
          <th>Name</th>
          <th>Address</th>
        </tr>
      ";

    while($row = $result -> fetch_array()){
      $html .= "
        <tr>
          <td>".$row['name']."</td>
          <td>".$row['address']."</td>
        </tr>
      ";
    }
  }elseif ($param == 'done' || $param == 'cancelled' || $param == 'requests') {
    $title = '<h4>List of Events</h4>';

    $html .= "
        <tr>
          <th>Request ID</th>
          <th>Client Name</th>
          <th>Starting Date</th>
          <th>Ending Date</th>
          <th>Venue</th>
        </tr>
      ";

    while($row = $result -> fetch_array()){
      $html .= "
        <tr>
          <td>".$row['requestID']."</td>
          <td>".$row['client_name']."</td>
          <td>".$row['starting_date']."</td>
          <td>".$row['ending_date']."</td>
          <td>".$row['venue']."</td>
        </tr>
      ";
    }
  }elseif ($param == 'officials') {
    $title = '<h4>List of Barangay Officials</h4>';

    $html .= "
        <tr>
          <th>Name</th>
          <th>Position</th>
          <th>Contact</th>
        </tr>
      ";

    while($row = $result -> fetch_array()){
      $html .= "
        <tr>
          <td>".$row['fullname']."</td>
          <td>".$row['position']."</td>
          <td>".$row['contact']."</td>
        </tr>
      ";
    }
  }

  $fullhtml = "
    <style>
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
      }
      
      td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 5px;
      }
    </style>
    $title
    <table>
      $html
    </table>
  ";

  $dompdf->loadHtml($fullhtml);
  $dompdf->setPaper('letter', 'portrait');
  $dompdf->render();
  $dompdf->stream();
?>