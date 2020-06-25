<?php

    $brand = $_POST['brand'];
    $year = $_POST['year'];
    $engine = $_POST['engine'];
    $transmission = $_POST['transmission'];
    $gps = $_POST['gps'];
    $parctronic = $_POST['parctronic'];
    $tv = $_POST['tv'];
    $doors = $_POST['doors'];

    $user = 'root';
    $pass = '';
    $db = 'rentacar';

    $db = new mysqli('localhost', $user, $pass, $db ) or die("Unable to connect to database");

    $query = "INSERT INTO cars (brand, year, doors, engine, transmission, gps, parktronic, tv)
    VALUES ('$brand', '$year', '$doors', '$engine', '$transmission', '$gps', '$parctronic', '$tv')";

    if ($db->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        return $db->error;
    }

    //$query = "INSERT INTO cars (brand, year, doors, engine, transmission, gps, parktronic, tv)
    //VALUES ($brand, $year, $doors, $engine, $transmission, $gps, $parctronic, $tv)";


?>
