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
                    <h1 class="mt-4">Devices</h1>
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
                                    Devices
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Device ID</th>
                                                <th>Code</th>
                                                <th>Acidity</th>
                                                <th>Temperature</th>
                                                <th>Soil Moisture</th>
                                                <th>Grow Light</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($device = mysqli_fetch_array($devices)) {
                                                $moist = "Moist";
                                                if($device["moisture"] == '1'){
                                                    $moist = "Moist";
                                                }
                                                else{
                                                    $moist = "Dry";
                                                }
                                                ?>
                                            <tr>
                                                <td><?php echo $device['device_id']; ?></td>
                                                <td><?php echo $device["code"]; ?></td>
                                                <td><?php echo $device["from_soil_acidity"]." - ".$device["to_soil_acidity"]."pH"; ?></td>
                                                <td><?php echo $device["from_temperature"]." - ".$device["to_temperature"]."°C"; ?></td>
                                                <td><?php echo $moist ?></td>
                                                <td><?php echo $device["from_light"]." - ".$device["to_light"]."hrs a day"; ?></td>
                                                <td>
                                                    <a href="edit_device.php?edit_device=<?php echo $device['device_id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
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