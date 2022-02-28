<?php
    include("dbh.php");
    
    if(isset($_POST['add_device'])){
        $code = $_POST['code'];
        $position = $_POST['position'];
        $description = $_POST['description'];

        
        $device_name = $mysqli->query("INSERT into devices (code, position, description) VALUES('$code','$position','$description')") or die ($mysqli->error);
        $device_id = $mysqli->query("SELECT id FROM devices ORDER BY id DESC LIMIT 1") or die ($mysqli->error);
        $id = $device_id->fetch_array();

        $id = $id['id'];
        $preset_id = $_POST['preset_id'];

        $presets = $mysqli->query("SELECT * FROM presets WHERE id = '$preset_id' ") or die ($mysqli->error);
        $preset = $presets->fetch_array();

        $from_soil_acidity = $preset["from_soil_acidity"];
        $to_soil_acidity = $preset["to_soil_acidity"];
        $from_temperature = $preset["from_temperature"];
        $to_temperature = $preset["to_temperature"];
        $moisture = $preset["moisture"];
        $from_light = $preset["from_light"];
        $to_light  = $preset["to_light"];

        $mysqli->query("INSERT into presets_device (from_soil_acidity, to_soil_acidity, from_temperature, to_temperature, moisture, from_light, to_light, device_id) VALUES('$from_soil_acidity','$to_soil_acidity','$from_temperature','$to_temperature','$moisture','$from_light','$to_light','$id')") or die ($mysqli->error);

        $_SESSION['notification'] = "Device has been added!";
        $_SESSION['msg_type'] = "success";

        header("location: devices.php");
    }

    if(isset($_POST['update_device'])){        
        $from_soil_acidity = $_POST["from_soil_acidity"];
        $to_soil_acidity = $_POST["to_soil_acidity"];
        $from_temperature = $_POST["from_temperature"];
        $to_temperature = $_POST["to_temperature"];
        $moisture = $_POST["moisture"];
        $from_light = $_POST["from_light"];
        $to_light  = $_POST["to_light"];
        $id = $_POST['device_id'];

        $mysqli->query("UPDATE presets_device SET from_soil_acidity = '$from_soil_acidity', to_soil_acidity = '$to_soil_acidity', from_temperature = '$from_temperature', to_temperature = '$to_temperature', moisture = '$moisture', from_light = '$from_light', to_light = '$to_light' WHERE device_id = '$id'  ") or die ($mysqli->error);

        $_SESSION['notification'] = "Device has been updated!";
        $_SESSION['msg_type'] = "success";

        header("location: devices.php");
    }
?>