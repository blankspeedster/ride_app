<?php
include("dbh.php");
//Get Vital
if (isset($_GET['getVital'])) {
    $user_id = $_GET["getVital"];
    $getVitals = mysqli_query($mysqli, "SELECT * FROM user_logs WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
    $vital = $getVitals->fetch_array();
    $response[] = array(
        "diastolic_bp"=>$vital['diastolic_bp'],
        "systolic_bp"=>$vital['systolic_bp'],
        "heart_rate_bpm"=>$vital['heart_rate_bpm'],
        "respiration_rate"=>$vital['respiration_rate'],
        "hrv"=>$vital['hrv'],
        "blood_oxygen_level"=>$vital['blood_oxygen_level'],
        "ambient_temperature"=>$vital['ambient_temperature'],
        "ambient_noise_level"=>$vital['ambient_noise_level'],
        "time_of_day"=>$vital['time_of_day'],
        "previous_activity_level"=>$vital['previous_activity_level']);
    echo json_encode($response[0]);
}

//Check Minutes
if(isset($_GET['checkMinutes'])){
    $user_id = $_GET["checkMinutes"];
    $getMinute = mysqli_query($mysqli, "SELECT * FROM message_sent WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($getMinute) <= 0){
        $response[] = array("minutes_passed"=>11);
        echo json_encode($response);
    }
    else{
        $minute = $getMinute->fetch_array();
        $date = date_default_timezone_set('Australia/Sydney');
        $current_date = date('Y-m-d H:i:s');
        $date1 = new DateTime($minute['date_time']);
        $date2 = new DateTime($current_date);
        $minutes = $date1->diff($date2);
        $mins = $minutes->i;
        $response[] = array("minutes_passed"=>$mins);
        echo json_encode($response[0]);
    }
}

//Create a message log
if(isset($_GET['createMessageLog'])){
    $date = date_default_timezone_set('Australia/Sydney');
    $current_date = date('Y-m-d H:i:s');
    $user_id = $_GET["createMessageLog"];
    mysqli_query($mysqli, "INSERT INTO message_sent (date_time, user_id) VALUES('$current_date','$user_id') ");
    $response[] = array("message"=>"Log recorded");
    echo json_encode($response[0]);
}


?>
