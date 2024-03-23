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
                <div class="containerd-fluid px-4">
                    <h1 class="mt-4">Download FitToRide Application</h1>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            You can download the Android Application below.
                                            <br>
                                            <a class="btn btn-primary btn-sm" href="assets/iResponse-v1.apk">
                                                <i class="fas fa-download"></i>
                                                 Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("footer.php"); ?>
</body>

</html>