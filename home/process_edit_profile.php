<?php
    include("dbh.php");
    //Process Edit Profile
    if(isset($_POST['update_profile'])){
        $user_id = $_SESSION['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $user_address = $_POST['user_address'];
        $phone_number = $_POST['phone_number'];
        $emergency_contact_name = $_POST['emergency_contact_name'];
        $emergency_contact_number = $_POST['emergency_contact_number'];
        $relationship = $_POST['relationship'];

        $mysqli->query("UPDATE users SET firstname = '$first_name', lastname = '$last_name', user_address = '$user_address', emergency_contact_name = '$emergency_contact_name', emergency_contact_number = '$emergency_contact_number', email = '$email', relationship = '$relationship' WHERE id = '$user_id' ") or die ($mysqli->error);
 
        $_SESSION['notification'] = "Profile has been updated";
        $_SESSION['msg_type'] = "success";
        header("location: edit_profile.php");
    }

?>