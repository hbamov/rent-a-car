<?php

    //get the data from ajax
    $location = $_POST['location'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $car_id = $_POST['car'];

    $user = 'root';
    $pass = '';
    $db = 'rentacar';

    //make the db connection
    $db = new mysqli('localhost', $user, $pass, $db ) or die("Unable to connect to database");

    //search if the selected car has a reservation
    $query = "SELECT * FROM reservations where car_id = $car_id";

    //run the query
    $result = $db->query($query);

    //check if there are results if not make reservation without additional check
    if (mysqli_num_rows($result)==0){
       $diff = (abs(strtotime($end_date) - strtotime($start_date)))/86400;

       //calculate the daily rent rate
       if($diff>7){
          $rent_rate = 16;
       }
       else if($diff>=4){
          $rent_rate = 18;
       }
       else $rent_rate = 20;

       //calculate the working days
       $begin = strtotime($start_date);
       $end   = strtotime($end_date);

       $no_days  = 0;
       $weekends = 0;
       while ($begin <= $end) {
          $no_days++; // number of days in the given interval
          $what_day = date("N", $begin);
          if ($what_day > 5) { // 6 and 7 are weekend days
             $weekends++;
          };
          $begin += 86400; // +1 day
       };
       $working_days = $no_days - $weekends;

       //calculate amount to pay
       $payable_amount = $rent_rate * $working_days;

       //insert in db
       $insertQuery = "INSERT INTO reservations (location, email, phone, car_id, start_date, end_date, days, price)
       VALUES ('$location', '$email', '$phone', '$car_id', '$start_date', '$end_date', $working_days, $payable_amount)";

       if ($db->query($insertQuery) === TRUE) {
          echo "Successfull Reservation. The amount you must pay is: $payable_amount €";
       } else {
          echo "Car is not available";
       }
    }
    else{ //if there is reservation for the selected car
      $issue = false;
      foreach($result as $row){
        //go through all reservations for the car and check for availability
        if( ($start_date>=$row['start_date'] && $start_date<=$row['end_date'])||
        ($end_date>=$row['start_date'] && $end_date<=$row['end_date'])||
        ($start_date<=$row['start_date'] && $end_date>=$row['end_date']) ){
          $issue = true;
        }
      }

      //if car is available
      if($issue == false){
        $diff = (abs(strtotime($end_date) - strtotime($start_date)))/86400;

        //calculate daily rent rate
        if($diff>7){
           $rent_rate = 16;
        }
        else if($diff>=4){
           $rent_rate = 18;
        }
        else $rent_rate = 20;

        //calculate working days
        $begin = strtotime($start_date);
        $end   = strtotime($end_date);

        $no_days  = 0;
        $weekends = 0;
        while ($begin <= $end) {
           $no_days++; // number of days in the given interval
           $what_day = date("N", $begin);
           if ($what_day > 5) { // 6 and 7 are weekend days
              $weekends++;
           };
           $begin += 86400; // +1 day
        };
        $working_days = $no_days - $weekends;

        //calculate amount to pay
        $payable_amount = $rent_rate * $working_days;

        //insert in db
        $insertQuery = "INSERT INTO reservations (location, email, phone, car_id, start_date, end_date, days, price)
        VALUES ('$location', '$email', '$phone', '$car_id', '$start_date', '$end_date', $working_days, $payable_amount)";

        if ($db->query($insertQuery) === TRUE) {
           echo "Successfull Reservation. The amount you must pay is: $payable_amount €";
        } else {
           echo "Car is not available";
        }
      }
      else echo "Car is not available";
    }


?>
