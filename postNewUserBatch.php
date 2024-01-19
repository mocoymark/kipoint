<?php
  session_start();

  require_once '../../vendor/autoload.php';
  include('../connection.php');
  include('emailer.php');

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

  $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  
  if(isset($_FILES['excelFile']['name']) && in_array($_FILES['excelFile']['type'], $file_mimes)) {
  
    $arr_file = explode('.', $_FILES['excelFile']['name']);
    $extension = end($arr_file);
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);
    $sheetData = $spreadsheet -> getActiveSheet() -> toArray();
      
    if(!empty($sheetData)) {
      for ($i = 1; $i < count($sheetData); $i++) {
        $alphabet = str_split('abcdefghijklmnopqrstuvwxyz');
        shuffle($alphabet);

        $randomizedAlphabet = implode('', $alphabet);
        $password = $randomizedAlphabet;
        // $fullname = $sheetData[$i][0];
        $lastname = $sheetData[$i][0];
        $firstname = $sheetData[$i][1];
        $middlename = $sheetData[$i][2];
        $email = $sheetData[$i][3];
        $contact = $sheetData[$i][4];
        $age = $sheetData[$i][5];
        $birthdate = $sheetData[$i][6];
        $complete_address = $sheetData[$i][7];

        $middleInitial = $middlename[0];
        $fullname = "$lastname, $firstname $middleInitial";

        $checkInDatabase = $conn -> query("SELECT * FROM useraccounts WHERE fullname='$fullname'");
        $exploded = explode('@', $email);
        $username = $exploded[0];
        
        // Process Full Name

        if($row = $checkInDatabase -> fetch_array()){

        }else {
          $conn -> query("INSERT INTO useraccounts(fullname, lastname, firstname, middlename, email, contact_number, age, birthdate, complete_address, username, password, temporary_password, status) VALUES(
            '$fullname', 
            '$lastname', 
            '$firstname', 
            '$middlename', 
            '$email', 
            '$contact',
            '$age',
            '$birthdate',
            '$complete_address',
            '$username',
            '$password',
            '$password',
            'Registered')
          ");

          informUser($email, $fullname, $username, $password);

          $currentDate = date('F j, Y h:i a');
          $message = $fullname . ' was added to Kipoints Database.';
          $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");
        }
      }
      echo 1;
    }
  }else {
    echo 0;
  }

  $conn -> close();
?>


