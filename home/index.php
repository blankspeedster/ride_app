<?php
require_once("process_index.php");
$user_id = $_SESSION['user_id'];
$heartrate = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
$respiration = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
$bloodPressureDiastolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
$bloodPressureSystolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);

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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                    </ol>

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Heart Rate
                                </div>
                                <div class="card-body"><canvas id="heartRateChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Blood Pressure Diastolic
                                </div>
                                <div class="card-body"><canvas id="bloodPressureChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Blood Pressure Systolic
                                </div>
                                <div class="card-body"><canvas id="bloodPressureChartSystolic" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Respiration
                                </div>
                                <div class="card-body"><canvas id="respirationChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>


                    <br>
                </div>
            </main>
            <?php include("footer.php"); ?>
            <script>
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            age: 1,
                            blood_pressure_systolic: 1,
                            blood_pressure_diastolic: 1,
                            blood_pressure: 1,
                            heart_rate: 1,
                            respiration: 1,

                            allow: "yes",
                            suggestions: "",

                            fireError: false,
                            fireMessage: "",
                            replied: false,
                        }
                    },
                    methods: {
                        updateProfile() {
                            alert("Your data: " + JSON.stringify(this.user));
                        },
                    },
                    async created() {
                        console.log("vue here!");
                    }
                });
            </script>
            <script>
                // HeartRate
                var ctx = document.getElementById("heartRateChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while ($hr = mysqli_fetch_array($heartrate)) {
                                        echo "\"" . $hr['date_time'] . "\",";
                                    }  ?>],
                        datasets: [{
                            label: "Heart Rate",
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
                                    $heartrate = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                                    while ($hr = mysqli_fetch_array($heartrate)) {
                                        echo $hr['heart_rate_bpm'] . ",";
                                    }  ?>],
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


                // Blood Pressure Diastolic
                var bloodPressureCtX = document.getElementById("bloodPressureChart");
                var myLineChart = new Chart(bloodPressureCtX, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while ($hr = mysqli_fetch_array($bloodPressureDiastolic)) {
                                        echo "\"" . $hr['date_time'] . "\",";
                                    }  ?>],
                        datasets: [{
                            label: "Blood Pressure Diastolic",
                            lineTension: 0.3,
                            backgroundColor: "rgba(249, 67, 0, 0.1)",
                            borderColor: "#D50000",
                            pointRadius: 5,
                            pointBackgroundColor: "#D50000",
                            pointBorderColor: "#D50000",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#D50000",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: [<?php
                                    $diastolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                                    while ($hr = mysqli_fetch_array($diastolic)) {
                                        echo $hr['systolic_bp'] . ",";
                                    }  ?>],
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

                // Blood Pressure Systolic
                var bloodPressureCtX = document.getElementById("bloodPressureChartSystolic");
                var myLineChart = new Chart(bloodPressureCtX, {
                    type: 'line',
                    data: {
                        labels: [<?php while ($hr = mysqli_fetch_array($bloodPressureSystolic)) {
                                        echo "\"" . $hr['date_time'] . "\",";
                                    }  ?>],
                        datasets: [{
                            label: "Blood Pressure Systolic",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0,77,63, 0.1)",
                            borderColor: "#004D40",
                            pointRadius: 5,
                            pointBackgroundColor: "#004D40",
                            pointBorderColor: "#004D40",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#004D40",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: [<?php
                                    $systolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                                    while ($hr = mysqli_fetch_array($systolic)) {
                                        echo $hr['diastolic_bp'] . ",";
                                    }  ?>],
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


                //Respiration
                var respirationChart = document.getElementById("respirationChart");
                var myLineChart = new Chart(respirationChart, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while ($rp = mysqli_fetch_array($respiration)) {
                                        echo "\"" . $rp['date_time'] . "\",";
                                    }  ?>],
                        datasets: [{
                            label: "Respiration",
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
                                    $respiration = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                                    while ($rp = mysqli_fetch_array($respiration)) {
                                        echo $rp['respiration_rate'] . ",";
                                    }  ?>],
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
            </script>
</body>

</html>