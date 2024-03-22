<?php

    if(!isset($_SESSION))
    {
        session_start();
    }

    $host = 'localhost';
    $username = 'ride_app_database';
    $password = 'ride_app_database';
    $database = 'ride_app_database';

    #  Pa$$w0rd123%%%@#$ - for MS Azure

    // myVm-mining-mvp_key - for Azure

    $mysqli = new mysqli($host,$username,$password,$database) or die(mysqli_error($mysqli));

?>