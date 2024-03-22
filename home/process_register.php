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
            $_SESSION['emergency_contact_name'] = $newCheckUser["emergency_contact_name"];

            $user_id = $_SESSION['user_id'];

            # create a variable to check if it is {'Afternoon': 0, 'Evening': 1, 'Morning': 2, 'Night': 3} depending on the time of the day
            $time_of_day = date('H');
            if($time_of_day >= 6 && $time_of_day < 12){
                $time_of_day = 2;
            }
            elseif($time_of_day >= 12 && $time_of_day < 18){
                $time_of_day = 0;
            }
            elseif($time_of_day >= 18 && $time_of_day < 24){
                $time_of_day = 1;
            }
            else{
                $time_of_day = 3;
            }

            # generate a random number based on date and time
            $date_time = date('Y-m-d H:i:s');
            # convert the date_time to an integer we can pass to srand
            $date_time = strtotime($date_time);
            srand($date_time);
            # using random seed to generate random values for the user logs
            $systolic_bp = rand(60, 100);
            $diastolic_bp = rand(70, 90);
            $heart_rate_bpm = rand(60, 100);
            $hrv = rand(20, 100);
            $respiration_rate = rand(12, 20);
            $blood_oxygen_level = rand(95, 100);
            $ambient_temperature = rand(15, 30);
            $ambient_noise_level = rand(30, 80);
            $previous_activity_level = rand(0, 10000);

            $mysqli->query("INSERT INTO user_logs(user_id, systolic_bp, diastolic_bp, heart_rate_bpm, respiration_rate, hrv, blood_oxygen_level, ambient_temperature, ambient_noise_level, time_of_day, previous_activity_level)
            VALUES ('$user_id', '$systolic_bp', '$diastolic_bp', '$heart_rate_bpm', '$respiration_rate', '$hrv', '$blood_oxygen_level', '$ambient_temperature', '$ambient_noise_level', '$time_of_day', '$previous_activity_level')")
            or die ($mysqli->error);

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

            //Get lsat inserted id
            $user_id = $mysqli->insert_id;
            
            //Get current date and time
            $date = date_default_timezone_set('Australia/Sydney');
            $current_date = date('Y-m-d H:i:s');
            
            //Insert message to the database
            $mysqli->query("INSERT INTO message_sent
            (date_time, user_id)
            VALUES ('$current_date', '$user_id')") or die ($mysqli->error);            
        }

        header("location: register.php");
    }

    //Override Vitals
    if(isset($_POST['override_vitals']))
    {
        $email = $_POST['email'];

        $time_of_day = date('H');
        if($time_of_day >= 6 && $time_of_day < 12){
            $time_of_day = 2;
        }
        elseif($time_of_day >= 12 && $time_of_day < 18){
            $time_of_day = 0;
        }
        elseif($time_of_day >= 18 && $time_of_day < 24){
            $time_of_day = 1;
        }
        else{
            $time_of_day = 3;
        }

        $date_time = date('Y-m-d H:i:s');
        # using random seed to generate random values for the user logs
        $systolic_bp = $_POST['systolic_bp'];
        $diastolic_bp = $_POST['diastolic_bp'];
        $heart_rate_bpm = $_POST['heart_rate_bpm'];
        $hrv = $_POST['hrv'];
        $respiration_rate = $_POST['respiration_rate'];
        $blood_oxygen_level = $_POST['blood_oxygen_level'];
        $ambient_temperature = $_POST['ambient_temperature'];
        $ambient_noise_level = $_POST['ambient_noise_level'];
        $previous_activity_level = $_POST['previous_activity_level'];

        $checkUser = $mysqli->query("SELECT * FROM users WHERE email='$email' ")or die ($mysqli->error);
        $newCheckUser = $checkUser->fetch_array();
        $user_id = $newCheckUser['id'];

        $mysqli->query("INSERT INTO user_logs(user_id, systolic_bp, diastolic_bp, heart_rate_bpm, respiration_rate, hrv, blood_oxygen_level, ambient_temperature, ambient_noise_level, time_of_day, previous_activity_level)
        VALUES ('$user_id', '$systolic_bp', '$diastolic_bp', '$heart_rate_bpm', '$respiration_rate', '$hrv', '$blood_oxygen_level', '$ambient_temperature', '$ambient_noise_level', '$time_of_day', '$previous_activity_level')")
        or die ($mysqli->error);

        header("location: override_log.php");
    }

        //Override Vitals
        if(isset($_POST['override_area']))
        {
            $email = $_POST['email'];
            $area = $_POST['area'];

            $mysqli->query(" UPDATE users SET current_area = '$area' WHERE email =  '$email' ") or die ($mysqli->error);

            header("location: override_area.php");
        }
