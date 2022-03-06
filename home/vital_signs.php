<?php
require_once("process_index.php");
$presets = $mysqli->query("SELECT * FROM presets") or die($mysqli->error);
$devices = $mysqli->query("SELECT * FROM devices d
JOIN presets_device p
ON p.device_id = d.id") or die($mysqli->error);
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
                    <h1 class="mt-4">Vital Signs Log</h1>
                    <h5>Hi Mark! Good day.</h5>
                    <h6>Here are your vital signs today. (<?php echo date("Y/m/d"); ?>)</h6>
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
                    <div class="row" style="display: none;">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-tablet-alt"></i>
                                    Add Device
                                </div>
                                <div class="card-body">
                                    <form method="post" action="process_device.php">
                                        <div class="row">
                                            <div class="col-xl-3">
                                                Preset
                                                <select class="form-control" name="preset_id">
                                                    <?php while ($preset = mysqli_fetch_array($presets)) { ?>
                                                        <option value="<?php echo $preset["id"]; ?>"><?php echo $preset["name"]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-xl-3">
                                                Code
                                                <input name="code" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                Position
                                                <input name="position" type="text" class="form-control" required>
                                            </div>

                                            <div class="col-xl-3">
                                                Description
                                                <input name="description" type="text" class="form-control" required>
                                                <br>
                                                <button style="float: right;" class="btn btn-primary btn-sm" type="submit" name="add_device">Add Device</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- List of Devices -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-tablet-alt"></i>
                                    Vital Logs for the week
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Day #</th>
                                                <th>Sumarry</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Day 1</td>
                                                <td>
                                                    Blood Pressure Systolic: 125<br>
                                                    Blood Pressure Diastolic: 80<br>
                                                    Heart Rate: 70<br>
                                                    Respiration Rate: 98<br>
                                                    <label class="text-success"><b>Approve Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 2</td>
                                                <td>
                                                    Blood Pressure Systolic: 128<br>
                                                    Blood Pressure Diastolic: 80<br>
                                                    Heart Rate: 80<br>
                                                    Respiration Rate: 98<br>
                                                    <label class="text-success"><b>Approve Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 3</td>
                                                <td>
                                                    Blood Pressure Systolic: 120<br>
                                                    Blood Pressure Diastolic: 70<br>
                                                    Heart Rate: 60<br>
                                                    Respiration Rate: 80<br>
                                                    <label class="text-danger"><b>Reject Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 4</td>
                                                <td>
                                                    Blood Pressure Systolic: 105<br>
                                                    Blood Pressure Diastolic: 80<br>
                                                    Heart Rate: 65<br>
                                                    Respiration Rate: 81<br>
                                                    <label class="text-danger"><b>Reject Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 5</td>
                                                <td>
                                                    Blood Pressure Systolic: 100<br>
                                                    Blood Pressure Diastolic: 70<br>
                                                    Heart Rate: 65<br>
                                                    Respiration Rate: 85<br>
                                                    <label class="text-danger"><b>Reject Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 6</td>
                                                <td>
                                                    Blood Pressure Systolic: 120<br>
                                                    Blood Pressure Diastolic: 80<br>
                                                    Heart Rate: 80<br>
                                                    Respiration Rate: 88<br>
                                                    <label class="text-success"><b>Approve Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Day 7</td>
                                                <td>
                                                    Blood Pressure Systolic: 120<br>
                                                    Blood Pressure Diastolic: 70<br>
                                                    Heart Rate: 60<br>
                                                    Respiration Rate: 80<br>
                                                    <label class="text-danger"><b>Reject Long Ride</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Recommendations:</strong>
                                                    <!-- <hr> --><br>
                                                    Always bring your water. Get enough rest before your Long Ride.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Suggestions:</strong>
                                                    <!-- <hr> --><br>
                                                    Don't forget to bring the following:<br>

                                                    Eye Wear<br>
                                                    Helmet<br>
                                                    Flashlight<br>
                                                    Emergency Kit (Medicine Kit)<br>
                                                    Vehicle Speedometer<br>
                                                    Air Pump<br>
                                                    Allen Wrench Set<br>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Checklist / Tips:</strong>
                                                    <!-- <hr> --><br>
                                                    Check the following<br>
                                                    Tire Air Pressure<br>
                                                    Chain Lubricant<br>
                                                    Brake Pads<br>
                                                    Brake Levers<br>
                                                    Extra Money<br>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("footer.php"); ?>
</body>

</html>