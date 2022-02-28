<?php
require_once("process_index.php");
$devices = $mysqli->query("SELECT * FROM devices") or die ($mysqli->error);
$device = $devices->fetch_array();
$temperatures = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
$humidity = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
$moistures = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
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
                    <div class="row">

                        <!-- <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Primary Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Warning Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Danger Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Temperature Logs of the Device (<?php echo $device['code']; ?>)
                                </div>
                                <div class="card-body"><canvas id="temperatureChart" width="100%" height="80"></canvas></div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Moisture Logs of the Device (<?php echo $device['code']; ?>)
                                </div>
                                <div class="card-body"><canvas id="moistureChart" width="100%" height="80"></canvas></div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Humidity Logs of the Device (<?php echo $device['code']; ?>)
                                </div>
                                <div class="card-body"><canvas id="humidityChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>                        

                        <!-- <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </main>
            <?php include("footer.php"); ?>
            <script>
                // Temperature
                var ctx = document.getElementById("temperatureChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while($temperature=mysqli_fetch_array($temperatures)){echo "\"".$temperature['time_log']."\",";}  ?>],
                        datasets: [{
                            label: "Temperature",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0.2)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: [<?php
                            $temperatures = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
                            while($temperature=mysqli_fetch_array($temperatures)){echo $temperature['temperature'].",";}  ?>],
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 110,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: true
                        }
                    }
                });

                // Humidity
                var ctx = document.getElementById("humidityChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while($humid=mysqli_fetch_array($humidity)){echo "\"".$humid['time_log']."\",";}  ?>],
                        datasets: [{
                            label: "Temperature",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0.2)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: [<?php
                            $humidity = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
                            while($humid=mysqli_fetch_array($humidity)){echo $humid['humidity'].",";}  ?>],
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 110,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: true
                        }
                    }
                });
                


                // Moisture
                var moistureChart = document.getElementById("moistureChart");
                var myMoistureChart = new Chart(moistureChart, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while($moisture=mysqli_fetch_array($moistures)){echo "\"".$moisture['time_log']."\",";}  ?>],
                        datasets: [{
                            label: "Moisture",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0.2)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: [<?php
                            $moistures = $mysqli->query("SELECT * FROM logs") or die ($mysqli->error);
                            while($moisture=mysqli_fetch_array($moistures)){
                                // $maxVal = 1023;
                                // $moisturePercentage = 1023 - $moisture['moisture'];
                                // $moisturePercentage = $moisturePercentage / 1023;
                                // $moisturePercentage = $moisturePercentage * 100;
                                $moisturePercentage = $moisture['moisture'];

                                echo $moisturePercentage.",";}
                                ?>],
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 1.1,
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                }
                            }],
                        },
                        legend: {
                            display: true
                        }
                    }
                });

            </script>
</body>

</html>