<?php
require_once("process_index.php");
$date_of_birth = $_SESSION['date_of_birth'];
$current_date = $date = date('Y-m-d H:i:s');
$date1 = new DateTime($date_of_birth);
$date2 = new DateTime($current_date);
$year = $date1->diff($date2);
$age = $year->y;
$user_id = $_SESSION['user_id'];
$getCurrentVital = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1") or die($mysqli->error);
$currentVital = $getCurrentVital->fetch_array();
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
                                    Heart Rate (BPM)
                                </div>
                                <div class="card-body"><canvas id="humidityChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <h5>Hi <?php echo $_SESSION['firstname']; ?>! Good day.</h5>
                            <h6>Here are your vital signs today. (<?php echo date("Y/m/d"); ?>)</h6>
                        </div>
                        <div class="col-xl-3" style="display: none;">
                            <label>Age</label>
                            <input type="text" class="form-control" v-model="age" readonly>
                        </div>

                        <div class="col-xl-3">
                            <label>Blood Pressure Systolic</label>
                            <input type="number" class="form-control" v-model="systolic_bp">
                        </div>

                        <div class="col-xl-3">
                            <label>Blood Pressure Diastolic</label>
                            <input type="number" class="form-control" v-model="diastolic_bp">
                        </div>

                        <div class="col-xl-3">
                            <label>Heart Rate (BPM)</label>
                            <input type="number" class="form-control" v-model="heart_rate_bpm">
                        </div>

                        <div class="col-xl-3">
                            <label>Heart Rate Variability (ms)</label>
                            <input type="number" class="form-control" v-model="hrv">
                        </div>

                        <div class="col-xl-3">
                            <label>Respiration Rate</label>
                            <input type="number" class="form-control" v-model="respiration_rate">
                        </div>

                        <div class="col-xl-3">
                            <label>Blood Oxygen Level</label>
                            <input type="number" class="form-control" v-model="blood_oxygen_level">
                        </div>

                        <div class="col-xl-3">
                            <label>Ambient Temperature</label>
                            <input type="number" class="form-control" v-model="ambient_temperature">
                        </div>

                        <div class="col-xl-3">
                            <label>Ambient Noise Level</label>
                            <input type="number" class="form-control" v-model="ambient_noise_level">
                        </div>

                        <div class="col-xl-3">
                            <label>Time of Day</label>
                            <input type="text" class="form-control" v-model="time_of_day_in_words">
                        </div>


                        <div class="col-xl-3">
                            <label>Previous Activity Level</label>
                            <input type="text" class="form-control" v-model="previous_activity_level">
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

                <?php
                $user_id = $_SESSION['user_id'];
                $heartrate = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                $respiration = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                $bloodPressureDiastolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                $bloodPressureSystolic = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id'") or die($mysqli->error);
                ?>

                <div class="container-fluid px-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <h5>Chart and Vital Signs</h5>
                            <div class="text-center mt-4 mb-4">
                                <button type="submit" class="btn btn-primary btn-fill float-right" @click="showAutomaticVitalSigns">
                                    Automatic (Vital Signs Detection)
                                </button>
                            </div>

                            <!-- start the graph here -->
                            <span v-show="showVitalSigns">
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
                            </span>
                            <!-- end the graph here -->
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
                            age: <?php echo $age; ?>,
                            heart_rate_bpm: <?php echo $currentVital['heart_rate_bpm']; ?>,
                            hrv: <?php echo $currentVital['hrv']; ?>,
                            systolic_bp: <?php echo $currentVital['systolic_bp']; ?>,
                            diastolic_bp: <?php echo $currentVital['diastolic_bp']; ?>,
                            respiration_rate: <?php echo $currentVital['respiration_rate']; ?>,
                            blood_oxygen_level: <?php echo $currentVital['blood_oxygen_level']; ?>,
                            ambient_temperature: <?php echo $currentVital['ambient_temperature']; ?>,
                            ambient_noise_level: <?php echo $currentVital['ambient_noise_level']; ?>,
                            time_of_day: <?php echo $currentVital['time_of_day']; ?>,
                            time_of_day_in_words: "",
                            previous_activity_level: <?php echo $currentVital['previous_activity_level']; ?>,

                            allow: "yes",
                            suggestions: "",

                            fireError: false,
                            fireMessage: "",
                            replied: false,
                            showVitalSigns: false
                        }
                    },
                    methods: {
                        updateProfile() {
                            alert("Your data: " + JSON.stringify(this.user));
                        },

                        showAutomaticVitalSigns(){
                            if(this.showVitalSigns === true)
                            {
                                this.showVitalSigns = false
                            }
                            else
                            {
                                this.showVitalSigns = true
                            }
                        },

                        async validatePredictProgram() {
                            this.fireError = true;
                            this.errorMessage = "Loading...";
                            var data = new FormData();

                            // # Heart_Rate_(BPM)
                            // # HRV_(ms)
                            // # Systolic_BP_(mmHg)
                            // # Diastolic_BP_(mmHg)
                            // # Respiration_Rate_(Breaths_per_Minute)
                            // # Blood_Oxygen_Level_(SpO2)
                            // # Ambient_Temperature_(C)
                            // # Ambient_Noise_Level_(dB)
                            // # Time_of_Day
                            // # Previous_Activity_Level_(Steps)
                            // # Age
                            // # Is_Fit
                            
                            data.append("heart_rate_bpm", this.heart_rate_bpm);
                            data.append("hrv", this.hrv);
                            data.append("systolic_bp", this.systolic_bp);
                            data.append("diastolic_bp", this.diastolic_bp);
                            data.append("respiration_rate", this.respiration_rate);
                            data.append("blood_oxygen_level", this.blood_oxygen_level);
                            data.append("ambient_temperature", this.ambient_temperature);
                            data.append("ambient_noise_level", this.ambient_noise_level);
                            data.append("time_of_day", this.time_of_day);
                            data.append("previous_activity_level", this.previous_activity_level);
                            data.append("age", this.age);
                            console.log(data);
                            // data.append("age", this.age);
                            // data.append("blood_pressure_systolic", this.blood_pressure_systolic);
                            // data.append("blood_pressure_diastolic", this.blood_pressure_diastolic);
                            // data.append("heart_rate", this.heart_rate);
                            // data.append("respiration", this.respiration);

                            // https://floating-everglades-04272.herokuapp.com/
                            // http://127.0.0.1:5000/
                            var config = {
                                method: "post",
                                url: "https://floating-everglades-04272.herokuapp.com/get-suggestion",
                                headers: {
                                    'Content-Type': 'application/json'
                                },
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
                    },
                    async mounted() {
                        this.validatePredictProgram();
                        //modify time_of_day_in_words here:
                        if (this.time_of_day === 0) {
                            this.time_of_day_in_words = "Afternoon";
                        } else if (this.time_of_day === 1) {
                            this.time_of_day_in_words = "Evening";
                        } else if (this.time_of_day === 2) {
                            this.time_of_day_in_words = "Morning";
                        } else if (this.time_of_day === 3) {
                            this.time_of_day_in_words = "Night";
                        }
                    },
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