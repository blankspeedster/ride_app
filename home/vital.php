<?php
require_once("process_index.php");
$devices = $mysqli->query("SELECT * FROM devices") or die($mysqli->error);
$device = $devices->fetch_array();
$temperatures = $mysqli->query("SELECT * FROM logs") or die($mysqli->error);
$humidity = $mysqli->query("SELECT * FROM logs") or die($mysqli->error);
$moistures = $mysqli->query("SELECT * FROM logs") or die($mysqli->error);
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
                    <h1 class="mt-4">Vital Signs Monitoring</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                    </ol>

                    <div class="row mb-4" style="display: none;">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Heart Rate
                                </div>
                                <div class="card-body"><canvas id="humidityChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <div class="col-xl-12">
                            <h5>Hi Mark! Good day.</h5>
                            <h6>Here are your vital signs today. (<?php echo date("Y/m/d"); ?>)</h6>
                        </div>
                        <div class="col-xl-3">
                            <label>Age</label>
                            <input type="text" class="form-control" v-model="age">
                        </div>

                        <div class="col-xl-3">
                            <label>Blood Pressure Systolic</label>
                            <input type="number" class="form-control" v-model="blood_pressure_systolic">
                        </div>

                        <div class="col-xl-3">
                            <label>Blood Pressure Diastolic</label>
                            <input type="number" class="form-control" v-model="blood_pressure_diastolic">
                        </div>

                        <div class="col-xl-3">
                            <label>Heart Rate</label>
                            <input type="number" class="form-control" v-model="heart_rate">
                        </div>

                        <div class="col-xl-3">
                            <label>Respiration</label>
                            <input type="number" class="form-control" v-model="respiration">
                        </div>

                        <div v-if="replied" class="col-md-12">
                            <br>
                            Allow Ride: {{allow}}<br>
                            Please Follow these Recommendations: {{suggestions}}
                        </div>
                        <div v-if="fireError" class="col-md-12">
                            {{errorMessage}}
                        </div>


                        <div class="text-center mt-4 mb-4">
                            <button type="submit" class="btn btn-primary btn-fill float-right" @click.prevent="validatePredictProgram">
                                Proceed
                            </button>
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
                        async validatePredictProgram() {
                            this.fireError = true;
                            this.errorMessage = "Loading...";
                            var data = new FormData();

                            data.append("age", this.age);
                            data.append("blood_pressure_systolic", this.blood_pressure);
                            data.append("blood_pressure_diastolic", this.blood_pressure);
                            data.append("heart_rate", this.heart_rate);
                            data.append("respiration", this.respiration);

                            // https://floating-everglades-04272.herokuapp.com/
                            // http://127.0.0.1:5000/
                            var config = {
                                method: "post",
                                url: "https://floating-everglades-04272.herokuapp.com/get-suggestion",
                                headers: {},
                                data: data,
                            };

                            await axios(config)
                                .then((response) => {
                                    this.replied = true;
                                    console.log(response.data);
                                    this.allow = response.data.allow;
                                    this.suggestions = response.data.suggestions;
                                    this.fireError = false;
                                })
                                .catch((error) => {
                                    this.replied = true;
                                    this.fireError = true;
                                    this.errorMessage =
                                        "There is an error attempting to predict the population";
                                });
                        },
                    },
                    async created() {
                        console.log("vue here!");
                    }
                });
            </script>
            <script>
                // Humidity
                var ctx = document.getElementById("humidityChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        // labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 14"],
                        labels: [<?php while ($humid = mysqli_fetch_array($humidity)) {
                                        echo "\"" . $humid['time_log'] . "\",";
                                    }  ?>],
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
                                    $humidity = $mysqli->query("SELECT * FROM logs") or die($mysqli->error);
                                    while ($humid = mysqli_fetch_array($humidity)) {
                                        echo $humid['humidity'] . ",";
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