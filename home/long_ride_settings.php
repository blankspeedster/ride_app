<?php
require_once("process_index.php");
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['firstname'];

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
                    <h1 class="mt-4">Long Ride Settings</h1>
                    <h5>Hi! <?php echo $first_name; ?> plan your long ride.</h5>
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
                                    Configure
                                </div>

                                <form method="post" action="process_long_ride_settings.php">

                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="text" placeholder="Destination" name="destination" />
                                                    <label for="destination">Destination</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="date" placeholder="" name="date_" />
                                                    <label for="date_">Date</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" type="time" placeholder="" name="time" />
                                                    <label for="time">Time</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <textarea class="form-control" style="height: 300px;" name="checklist"></textarea>
                                                    <label for="checklist">Additional item for checklist?</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <button class="d-grid btn btn-primary btn-block" type="submit" name="save_checklist">
                                                        Proceed
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
            <main>
                <div class="container-fluid px-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Long Ride Check List
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Destination</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Checklists</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php  
                                    $checklists = $mysqli->query(" SELECT * FROM long_ride_setting WHERE user_id = '$user_id' ORDER BY id DESC ") or die ($mysqli->error);
                                    while($checklist = mysqli_fetch_array($checklists)){
                                ?>
                                    <tr>
                                        <td><?php echo $checklist['id'];?></td>
                                        <td><?php echo $checklist['destination'];?></td>
                                        <td><?php echo $checklist['date'];?></td>
                                        <td><?php echo $checklist['time'];?></td>
                                        <td><?php echo $checklist['checklist'];?></td>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("footer.php"); ?>
</body>

</html>