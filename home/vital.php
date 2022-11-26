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
                                    Heart Rate
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
                            age: <?php echo $age; ?>,
                            blood_pressure_systolic: <?php echo $currentVital['systolic']; ?>,
                            blood_pressure_diastolic: <?php echo $currentVital['diastolic']; ?>,
                            // blood_pressure: 100,
                            heart_rate: <?php echo $currentVital['heart_rate']; ?>,
                            respiration: <?php echo $currentVital['respiration']; ?>,

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
                            data.append("blood_pressure_systolic", this.blood_pressure_systolic);
                            data.append("blood_pressure_diastolic", this.blood_pressure_diastolic);
                            data.append("heart_rate", this.heart_rate);
                            data.append("respiration", this.respiration);

                            // https://floating-everglades-04272.herokuapp.com/
                            // http://127.0.0.1:5000/
                            var config = {
                                method: "post",
                                url: "https://floating-everglades-04272.herokuapp.com/get-suggestion",
                                headers: {'Content-Type': 'application/json'},
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
                    },
                });
            </script>
</body>

</html>