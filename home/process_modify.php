<?php
    include("dbh.php");
    if(isset($_POST['add_log'])){
        $temperature = $_POST['temperature'];
        $moisture = ucfirst($_POST['moisture']);
        $humidity = $_POST["humidity"];
        $device_id = 1;

        $mysqli->query(" INSERT INTO logs ( device_id, temperature, moisture, humidity) VALUES('$device_id','$temperature','$moisture', '$humidity') ") or die ($mysqli->error);

        $_SESSION['notification'] = "Log has been added!";
        $_SESSION['msg_type'] = "success";

        header("location: modify.php");
    }

    if(isset($_GET['clear_log'])){
        $device_id = $_GET['clear_log'];

        $mysqli->query("DELETE FROM logs WHERE device_id = '$device_id' ") or die ($mysqli->error);

        $_SESSION['notification'] = "Logs has been cleared!";
        $_SESSION['msg_type'] = "danger";

        header("location: modify.php");
    }

    //Modify Light
    if(isset($_POST['modify_light'])){
        $device_id = "1";
        $light_on = $_POST["light"];

        $mysqli->query("UPDATE devices SET light_on = '$light_on' WHERE id = '1' ") or die ($mysqli->error);

        $_SESSION['notification'] = "Light has been modified!";
        $_SESSION['msg_type'] = "warning";

        header("location: modify.php");
    }


    //Modify Fan
    if(isset($_POST['modify_fan'])){
        $device_id = "1";
        $light_on = $_POST["fan"];

        $mysqli->query("UPDATE devices SET fan_on = '$light_on' WHERE id = '1' ") or die ($mysqli->error);

        $_SESSION['notification'] = "Fan has been modified!";
        $_SESSION['msg_type'] = "warning";

        header("location: modify.php");
    }

?>