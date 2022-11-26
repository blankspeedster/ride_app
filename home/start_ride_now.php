<?php
require_once("process_index.php");
$user_id = $_SESSION['user_id'];
$date_of_birth = $_SESSION['date_of_birth'];
$current_date = $date = date('Y-m-d H:i:s');
$date1 = new DateTime($date_of_birth);
$date2 = new DateTime($current_date);
$year = $date1->diff($date2);
$age = $year->y;
$getCurrentVital = $mysqli->query("SELECT * FROM user_logs WHERE user_id = '$user_id' ORDER BY date_time DESC LIMIT 1") or die($mysqli->error);
$currentVital = $getCurrentVital->fetch_array();

$phone_number = $_SESSION['emergency_contact_number'];
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
                    <h1 class="mt-4">Start Ride Now</h1>
                    <h5>Attempt to start a ride now and the application will closely monitor your vitals</h5>
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
                                    Map
                                </div>


                                <div class="card-body">

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <!-- Location in map -->
                                            <div class="card" style="height: 500px !important;">
                                                <div class="card-body">
                                                    <div id="map" style='width: 100%; height: 100%;'></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <button class="d-grid btn btn-primary btn-block" @click="checkMinute">
                                                    Sample Function Call
                                                </button>
                                                <br>
                                                {{sendingSMSMessage}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include("footer.php"); ?>
            <script>
                mapboxgl.accessToken = 'pk.eyJ1Ijoicm9uaWVzcGVlZHN0ZXIwMyIsImEiOiJjbGF4Ymh6dTQwbnpuM3VqdWZwMmoyaXNxIn0.u0-QP8LkNZK11mcjVnOH5w';
                const map = new mapboxgl.Map({
                    container: 'map', // container ID
                    style: 'mapbox://styles/mapbox/streets-v12', // style URL
                    center: [-74.5, 40], // starting position [lng, lat]
                    zoom: 9, // starting zoom
                });
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            lat: null,
                            long: null,
                            user_id: <?php echo $user_id; ?>,
                            // this part for the vitals
                            diastolic: <?php echo  $currentVital['diastolic']; ?>,
                            systolic: <?php echo  $currentVital['systolic']; ?>,
                            heart_rate: <?php echo  $currentVital['heart_rate']; ?>,
                            respiration: <?php echo  $currentVital['respiration']; ?>,
                            age: <?php echo $age; ?>,

                            minutes: 0,
                            allow: "NO",
                            phone_number: <?php echo $phone_number; ?>,
                            sample_message: null,
                            apiusername: "APIFB2NQXUV1L",
                            apipassword: "APIFB2NQXUV1LFB2NQ",
                            sendingSMSMessage: null,
                            first_name: "<?php echo $first_name; ?>",
                        }
                    },
                    methods: {
                        getLocation() {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(this.showPosition, this.showError);
                            } else {
                                this.long = "Geolocation is not supported by this browser.";
                            }
                        },
                        async showPosition(position) {
                            this.lat = position.coords.latitude;
                            this.long = position.coords.longitude;

                            var userLat = this.lat;
                            var userLong = this.long;

                            //Show Markers
                            var container = L.DomUtil.get('map');
                            if (container != null) {
                                container._leaflet_id = null;
                            }
                            var map = L.map('map').setView([userLat, userLong], 13);
                            var gl = L.mapboxGL({
                                attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
                                style: 'https://api.maptiler.com/maps/osm-standard/style.json?key=gcypTzmAMjrlMg46MJG3#5.9/16.04327/120.29239'
                            }).addTo(map);

                            var riderIcon = L.icon({
                                iconUrl: './assets/img/pin-map.png',
                                iconSize: [35, 50],
                                iconAnchor: [15, 25]
                            });

                            //Current Position
                            L.marker([userLat, userLong], {
                                    draggable: true,
                                    clickable: true,
                                    icon: riderIcon
                                }).on('dragend', (e) => {
                                    e.target.getLatLng().lat;
                                    e.target.getLatLng().lng;
                                    this.lat = e.target.getLatLng().lat;
                                    this.long = e.target.getLatLng().lng;
                                }).addTo(map)
                                .bindPopup('You are here', {
                                    autoPan: true
                                });

                            //Add Routing
                            // Code to Add Routing
                            // L.Routing.control({
                            //     waypoints: [
                            //         L.latLng(userLat, userLong),
                            //         L.latLng(15.158700522438865, 120.59249274173763) //SPCF
                            //     ]
                            // }).addTo(map);
                            // End Code to Routing

                        },

                        //Loop Get Location
                        async loopGetLocation() {
                            setInterval(() => {
                                this.getLocation();
                                this.getVitals();
                                this.predictAllowRide();
                                this.checkMinute();
                            }, 10000);
                            console.log("this is a loop");
                        },

                        //Get Vitals
                        async getVitals() {
                            const options = {
                                method: "GET",
                                url: "process_get_vital.php?getVital=" + this.user_id,
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response.data);
                                    this.diastolic = response.data.diastolic;
                                    this.systolic = response.data.systolic;
                                    this.heart_rate = response.data.heart_rate;
                                    this.respiration = response.data.respiration;
                                    this.predictAllowRide();
                                })
                                .catch((error) => {
                                    this.predictAllowRide();
                                });
                        },

                        //Get Minutes
                        async checkMinute() {
                            const options = {
                                method: "GET",
                                url: "process_get_vital.php?checkMinutes=" + this.user_id,
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.minutes = response.data.minutes_passed;
                                    if (this.minutes > 10 && this.allow === "NO") {
                                        this.sendMessage();
                                    }
                                    else{
                                        var _minremaining = 10 - this.minutes;
                                        this.sendingSMSMessage = "We just sent a message to your emergency contact number "+ this.minutes + " minute(s) ago. Wait for "+_minremaining+" minute(s). Please stay safe.";
                                    }
                                })
                                .catch((error) => {
                                    this.predictAllowRide();
                                });
                        },

                        //Send Message here
                        async sendMessage() {
                            this.sample_message = "The application sensed abnormality with "+this.first_name+". Please address the concern immediately.";
                            var _initial_message = "EMERGENCY ALERT! " + this.sample_message;
                            var _sample_message = encodeURIComponent(_initial_message);
                            var _url = "https://sgateway.onewaysms.com/apis10.aspx";
                            _url = _url + "?apiusername=" + this.apiusername;
                            _url = _url + "&apipassword=" + this.apipassword;
                            _url = _url + "&mobileno=" + this.phone_number;
                            _url = _url + "&senderid=onewaysms";
                            _url = _url + "&message=" + _sample_message;
                            _url = _url + "&languagetype=1";

                            var config = {
                                method: "post",
                                url: _url,
                                headers: {},
                            };

                            await axios(config)
                                .then((response) => {
                                    console.log(response.data);
                                })
                                .catch((error) => {
                                    console.log(error);
                            });

                            //Create a log of the message
                            var sendSMSConfig = {
                                method: "get",
                                url: "process_get_vital.php?createMessageLog=" + this.user_id,
                            };

                            await axios(sendSMSConfig)
                                .then((response) => {
                                    console.log(response.data);
                                })
                                .catch((error) => {
                                    console.log(error);
                            });                            

                        },

                        //Send Vitals
                        async predictAllowRide() {
                            this.fireError = true;
                            this.errorMessage = "Loading...";
                            var data = new FormData();

                            data.append("age", this.age);
                            data.append("blood_pressure_systolic", this.diastolic);
                            data.append("blood_pressure_diastolic", this.systolic);
                            data.append("heart_rate", this.heart_rate);
                            data.append("respiration", this.respiration);

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
                                    this.allow = response.data.allow;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Show Error
                        showError(error) {
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    this.long = "User denied the request for Geolocation."
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    this.long = "Location information is unavailable."
                                    break;
                                case error.TIMEOUT:
                                    this.long = "The request to get user location timed out."
                                    break;
                                case error.UNKNOWN_ERROR:
                                    this.long = "An unknown error occurred."
                                    break;
                            }
                        },
                    },
                    async created() {
                        // console.log("vue here!");
                    },
                    async mounted() {
                        // this.getLocation();
                        this.loopGetLocation();
                        // this.predictAllowRide();
                        // this.getVitals();
                    },
                });
            </script>
</body>

</html>