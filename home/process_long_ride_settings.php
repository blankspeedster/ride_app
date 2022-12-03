<?php
    include("dbh.php");
    if(isset($_POST['save_checklist'])){
        $destination = $_POST['destination'];
        
        if($_POST['date_'] == '')
        {
            $date_ = date("Y-m-d");
        }
        else
        {
            $date_ = $_POST['date_'];
        }

        $time = $_POST["time"];
        $checklist = $_POST["checklist"];
        $user_id = $_SESSION['user_id'];

        $mysqli->query(" INSERT INTO long_ride_setting (user_id, destination, date, time, checklist) VALUES('$user_id','$destination', '$date_', '$time', '$checklist') ") or die ($mysqli->error);

        $_SESSION['notification'] = "Checklist has been added!";
        $_SESSION['msg_type'] = "success";

        header("location: long_ride_settings.php");
    }
?>