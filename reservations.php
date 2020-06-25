<?php

  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $brand= $_POST['brand'];
  $year = $_POST['year'];
  $engine = $_POST['engine'];

  $brand = implode(',', $brand);

  $year = implode(',', $year);

  $engine = implode(',', $engine);

  $user = 'root';
  $pass = '';
  $db = 'rentacar';

  $db = new mysqli('localhost', $user, $pass, $db ) or die("Unable to connect to database");

  $query = "SELECT * FROM reservations
  INNER JOIN cars
  ON reservations.car_id = cars.id
  WHERE cars.brand IN ($brand)
  AND cars.year IN ($year)
  AND cars.engine IN ($engine)
  AND ((reservations.start_date >= '$start_date' AND reservations.start_date <= '$end_date')
  OR (reservations.end_date >= '$start_date' AND reservations.end_date <= '$end_date')
  OR (reservations.start_date <= '$start_date' and reservations.end_date >= '$end_date'))";
  $result = $db->query($query);

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
          <li class="nav-item">
            <a class="nav-link" href="rent.php">Rent Car</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="reserved.html">Reservations</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
      	<div class="card" style="margin-top:80px">
      	  <div class="card-block">
      	    <h4 class="card-title">Reservations</h4>
      	    <table class="table">
      		  <thead>
      		    <tr>
      		      <th>Pickup Location</th>
      		      <th>Email</th>
                <th>Phone</th>
                <th>Car Brand</th>
                <th>Year</th>
                <th>Engine</th>
                <th>Business Days</th>
                <th>Rent Amount</th>
      		    </tr>
      		  </thead>
      		  <tbody>
              <?php
                foreach($result as $row){
                  echo "<tr><td>".$row['location']."</td><td>".$row['email']."</td><td>".
                  $row['phone']."</td><td>".$row['brand']."</td><td>".$row['year']."</td><td>".
                  $row['engine']."</td><td>".$row['days']."</td><td>".$row['price']." €</td></tr>";
                }
              ?>
      		  </tbody>
      		</table>
      	  </div>
      	</div>
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
