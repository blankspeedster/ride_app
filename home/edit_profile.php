<?php
require_once("process_index.php");
$user_id = $_SESSION['user_id'];
$checkUser = $mysqli->query("SELECT * FROM users WHERE id = '$user_id' ");
$newCheckUser = $checkUser->fetch_array();
$first_name = $newCheckUser['firstname'];
$last_name = $newCheckUser['lastname'];
$user_address = $newCheckUser['user_address'];
$emergency_contact_name = $newCheckUser['emergency_contact_name'];
$emergency_contact_number = $newCheckUser['emergency_contact_number'];
$relationship = $newCheckUser['relationship'];
$email = $newCheckUser['email'];
$date_of_birth = $newCheckUser['date_of_birth'];
?>
<!DOCTYPE html>
<html lang="en">

<?php include("head.php"); ?>

<body class="sb-nav-fixed">
    <!-- Navbar Start-->
    <?php include("navbar.php"); ?>
    <!-- Navbar End-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Side Navigator Start -->
            <?php include("sidenav.php"); ?>
            <!-- Side Navigator End -->
        </div>
        <div id="layoutSidenav_content">

            <main id="vueApp">
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Profile</h1>
                    <h5>Edit your personal information and contact details in this page</h5>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                    </ol>
                    <div class="row">
                        <!-- Notification here -->
                        <?php
                        if (isset($_SESSION['notification'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                                <?php
                                echo $_SESSION['notification'];
                                unset($_SESSION['notification']);
                                ?>
                            </div>
                        <?php } ?>
                        <!-- End Notification -->
                    </div>

                    <!-- List of Devices -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-tablet-alt"></i>
                                    Profile
                                </div>

                                <form method="post" action="process_edit_profile.php">

                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="text" placeholder="First Name" name="first_name" value="<?php echo $first_name; ?>" />
                                                    <label for="first_name">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="text" placeholder="Last Name" name="last_name" value="<?php echo $last_name; ?>" />
                                                    <label for="last_name">Last Name</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="email" placeholder="Email Address" name="email" value="<?php echo $email; ?>" />
                                                    <label for="email">Email Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="text" placeholder="User Address" name="user_address" value="<?php echo $user_address; ?>" />
                                                    <label for="user_address">User Address</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6" style=" ">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="date" placeholder="Date of Birth" name="date_of_birth" value="<?php echo $date_of_birth; ?>" />
                                                    <label for="email">Date of Birth</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style=" ">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <label for="email">DOB: <?php echo $date_of_birth; ?></label>
                                                </div>          
                                            </div>          
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6" style=" ">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control">
                                                        <option disabled selected>Select Type of Smarwatch</option>
                                                        <option>Apple Series Watch (Apple Health and Fitness)</option>
                                                        <option>Android Smart Watch (Google Health Fit)</option>
                                                    </select>
                                                </div>
                                            </div>     
                                        </div>


                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <i>Emergency Contact Information</i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="name" placeholder="Contact Full Name" name="emergency_contact_name" value="<?php echo $emergency_contact_name; ?>" />
                                                    <label for="emergency_contact_name">Contact Full Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="text" placeholder="Emergency Contact Number" name="emergency_contact_number"value="<?php echo $emergency_contact_number; ?>" />
                                                    <label for="emergency_contact_number">Emergency Contact Number - e.g 639847038451</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="name" placeholder="Contact Full Name" name="relationship" value="<?php echo $relationship; ?>" />
                                                    <label for="relationship">Relationship</label>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <button class="d-grid btn btn-primary btn-block" type="submit" name="update_profile">
                                                        Update Profile Information
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include("footer.php"); ?>
</body>

</html>