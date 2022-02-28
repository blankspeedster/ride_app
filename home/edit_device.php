<?php
require_once("process_index.php");
$presets = $mysqli->query("SELECT * FROM presets") or die($mysqli->error);

if($_GET['edit_device']){
    $device_id = $_GET['edit_device'];
}
else{
    header("location: devices.php");
}

$devices = $mysqli->query("SELECT * FROM devices d
JOIN presets_device p
ON p.device_id = d.id WHERE device_id = '$device_id' ") or die($mysqli->error);
$device = $devices->fetch_array();

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
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Devices</h1>
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

                    <!-- Add Device -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-tablet-alt"></i>
                                    Edit Device - <?php echo $device["code"]; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="process_device.php">
                                        <div class="row">
                                            <div class="col-xl-3">
                                                From Soil Acidity
                                                <input value="<?php echo $device["from_soil_acidity"]; ?>" name="from_soil_acidity" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                To Soil Acidity
                                                <input value="<?php echo $device["to_soil_acidity"]; ?>" name="to_soil_acidity" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                From Temperature
                                                <input value="<?php echo $device["from_temperature"]; ?>" name="from_temperature" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                To Temperature
                                                <input value="<?php echo $device["to_temperature"]; ?>" name="to_temperature" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                Moisture
                                                <select class="form-control" name="moisture">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-3">
                                                From Light
                                                <input value="<?php echo $device["from_light"]; ?>" name="from_light" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                To Light
                                                <input value="<?php echo $device["to_light"]; ?>" name="to_light" type="text" class="form-control" required>
                                            </div>
                                            
                                        </div>
                                        <input type="text" name="device_id" value="<?php echo $device['device_id']?>" style="visibility: hidden;">
                                        <br>
                                        <button style="float: right;" class="btn btn-primary btn-sm" type="submit" name="update_device">Update Device</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </main>
            <?php include("footer.php"); ?>
</body>

</html>