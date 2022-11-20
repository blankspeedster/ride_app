<?php

    if(!isset($_SESSION))
    {
        session_start();
    }

    $host = 'localhost';
    $username = 'ride_app_database';
    $password = 'ride_app_database';
    $database = 'ride_app_database';

    $mysqli = new mysqli($host,$username,$password,$database) or die(mysqli_error($mysqli));

?>

<!-- theskqqb_ride_app_database -->