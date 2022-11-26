<?php
    include("dbh.php");
    //Process Login
    if(isset($_POST['login'])){
        $email = strtolower($_POST['email']);
        $password = $_POST['password'];

        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' AND user_password = '$password' ");

        if(mysqli_num_rows($checkUser) <= 0){
            $_SESSION['loginError'] = "Email not found or incorrect password. Please try again.";
            header("location: login.php?email=".$email);
        }
        else{
            $newCheckUser = $checkUser->fetch_array();
            $_SESSION['user_id'] = $newCheckUser["id"];
            $_SESSION['email'] = $newCheckUser["email"];
            $_SESSION['firstname'] = $newCheckUser["firstname"];
            $_SESSION['lastname'] = $newCheckUser["lastname"];
            $_SESSION['date_of_birth'] = $newCheckUser["date_of_birth"];
            $_SESSION['emergency_contact_number'] = $newCheckUser["emergency_contact_number"];

            $user_id = $_SESSION['user_id'];

            $mysqli->query("INSERT INTO user_logs(user_id, systolic, diastolic, heart_rate, respiration) VALUES('$user_id','100','100','80', '100') ");

            header("location: index.php");
        }
    }

    //Process for Registration
    if(isset($_POST['register_account']))
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $emergencyContactName = $_POST['emergencyContactName'];
        $emergencyContactNumber = $_POST['emergencyContactNumber'];
        $emergencyRelationship = $_POST['emergencyRelationship'];


        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' ");
        if(mysqli_num_rows($checkUser)>0)
        {
            $_SESSION['msg_type'] = "danger";
            $_SESSION['registerError'] = "Email already taken. Please try another email address.";
            header("location: register.php");
        }
        else{
            $mysqli->query("INSERT INTO users
            (firstname, lastname, user_address, emergency_contact_name, emergency_contact_number, relationship, email, user_password)
            VALUES ('$firstName', '$lastName', '$address', '$emergencyContactName', '$emergencyContactNumber', '$emergencyRelationship', '$email', '$password')") or die ($mysqli->error);
        }

        header("location: register.php");
    }
?>