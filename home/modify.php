<?php
require_once("process_modify.php");
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                    </ol>
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
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-temperature-high"></i>
                                    Modify Temperature / Add Logs
                                </div>
                                <div class="card-body">
                                    <form method="post" action="process_modify.php">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" min="0" max="1" id="moisture" name="moisture" type="number" placeholder="Soil Moisture" required />
                                                    <label for="inputFirstName">Soil Moisture (0 - No Moisture, 1 - With Moisture)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" min="-100" max="100" id="temperature" name="temperature" type="number" placeholder="Temperature in Celcius" required />
                                                    <label for="inputLastName">Temperature in Celcius</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" min="0" max="100" id="temperature" name="humidity" type="number" placeholder="Temperature in Celcius" required />
                                                    <label for="inputLastName">Humidity (0 - 100)</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-primary btn-block" type="submit" name="add_log">Add Log</button></div>
                                            <br>
                                            <div class=""><a style="float: right;" class="btn btn-danger btn-block" href="process_modify.php?clear_log=1">Clear Log</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-temperature-high"></i>
                                    Override opening of light and fan
                                </div>
                                <div class="card-body">
                                    <form method="post" action="process_modify.php">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div>
                                                    <label for="inputLastName">Light</label>
                                                    <select class="form-control" name="light">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    <br />
                                                    <button class="btn btn-primary btn-block" style="float: right;" type="submit" name="modify_light">Override Light</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="">
                                                    <label for="inputLastName">Fan</label>
                                                    <select class="form-control" name="fan">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    <br />
                                                    <button class="btn btn-primary btn-block" style="float: right;" type="submit" name="modify_fan">Override Fan</button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mt-4 mb-0">
                                            <!-- <div class="d-grid"><button class="btn btn-primary btn-block" type="submit" name="add_log">Add Log</button></div> -->
                                            <!-- <br> -->
                                            <!-- <div class=""><a style="float: right;" class="btn btn-danger btn-block" href="process_modify.php?clear_log=1">Clear Log</a></div> -->
                                        </div>
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