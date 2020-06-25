<?php

$user = 'root';
$pass = '';
$db = 'rentacar';

$db = new mysqli('localhost', $user, $pass, $db ) or die("Unable to connect to database");

$carsQuery = "SELECT * FROM cars";
$resultQuery = $db->query($carsQuery);

/*foreach($resultQuery as $result){
  echo '<pre>'; print_r($result['brand']); echo '</pre>';
}*/

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Rent a Car</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script type="text/javascript">
      $( document ).ready(function() {
        $('#start_date').datepicker({
          format:'yyyy-mm-dd',
          startDate: '-3d'
        });

        $('#end_date').datepicker({
          format:'yyyy-mm-dd',
          startDate: '-3d'
        });
      });

      function reserve() {

        var location = $( "#location" ).val();
        var email = $( "#email" ).val();
        var phone = $( "#phone" ).val();
        var start_date = $( "#start_date" ).val();
        var end_date = $( "#end_date" ).val();
        var car = $('#selected_car').val()


        $.ajax({
          method: "POST",
          url: "/make_reservation.php",
          data: {location:location, email:email, phone:phone,
            start_date:start_date, end_date:end_date, car:car
          },
          error:function() {
            alert('There was a problem with the reservation. Please try later.');
          }
        })
        .done(function( status ) {
          alert(status);
        });

      }
    </script>


  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add_car.html">Add Car</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="prices.html">Prices</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="rent.php">Rent Car</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reserved.html">Reservations</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" style="margin-top:55px;">
      <div class="container">
        <h3>Input Reservation Details</h3>
        <div class="form-group row">
          <label for="example-text-input" class="col-2 col-form-label">Pick-up Location</label>
          <div class="col-10">
            <input class="form-control" type="text" placeholder="Enter the pickup location" id="location">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-email-input" class="col-2 col-form-label">Email</label>
          <div class="col-10">
            <input class="form-control" type="email" placeholder="Enter your email" id="email">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-tel-input" class="col-2 col-form-label">Telephone</label>
          <div class="col-10">
            <input class="form-control" type="tel" placeholder="Enter your phone" id="phone">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-datetime-local-input" class="col-2 col-form-label">Start Date</label>
          <div class="col-10">
            <input class="form-control" data-provide="datepicker" placeholder="Enter the start of the rent" id="start_date">
          </div>
        </div>
        <div class="form-group row">
          <label for="example-date-input" class="col-2 col-form-label">End Date</label>
          <div class="col-10">
            <input class="form-control" data-provide="datepicker" placeholder="Enter the end of the rent" id="end_date">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-2 col-form-label">Available Cars</label>
          <div class="col-10">
            <select class="form-control" id="selected_car">
    		      <option value="" disabled selected>Select a Cars</option>
              <?php
                foreach($resultQuery as $result){
                  echo '<option value="'.$result['id'].'">'; print_r($result['brand'].' '.$result['year'].' '.$result['engine'].' '.$result['transmission']); echo '</option>';
                }
              ?>
    		    </select>
          </div>
        </div>
        <button type="button" class="btn btn-primary" onclick="reserve()">Submit</button>
      </div>
    </div>

    <div class="container">
      <hr>
      <footer>
        <p>&copy; Rent a Car 2017</p>
      </footer>
    </div> <!-- /container -->

  </body>
</html>
