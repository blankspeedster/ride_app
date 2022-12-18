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
            <main id="vueApp">
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Pairing of Device</h1>
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
                                    Add Device (The application uses third party API from Google)
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            Preset
                                            <select class="form-control" name="preset_id">
                                                <option>Xiaomi Band 5</option>
                                                <option>Huawei Band 6</option>
                                                <option>Samsung Galaxy Watch</option>
                                            </select>
                                        </div>

                                        <div class="col-xl-6">
                                            Action<br>
                                            <a class="btn btn-primary btn-sm" name="add_device" @click="connectDevice">Pair Device</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Connection -->
                    <div class="row" v-show="isConnect">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <span v-if="!isconnectionComplete">
                                                <h4>Connecting ({{progress }}%)...</h4>
                                                <br>
                                                Be sure your Bluetooth connection is open <br>
                                                Please wait for a while to connect to your smart watch.
                                            </span>
                                            <h4 v-if="isconnectionComplete">Device Connection Complete</h4>
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
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            isConnect: false,
                            isconnectionComplete: false,
                            progress: 0,
                        }
                    },
                    methods: {
                        getRandomInt(min, max) {
                            return Math.floor(Math.random() * (max - min + 1) + min)
                        },

                        connectDevice() {
                            this.isConnect = true;
                            let currentProgress = this.getRandomInt(this.progress, 100);
                            this.progress = currentProgress;
                            if (this.progress === 100) {
                                this.isconnectionComplete = true;
                            }
                            this.loopGetLocation();
                        },
                        //Loop Show Progress
                        loopGetLocation() {
                            setInterval(() => {
                                this.connectDevice();
                            }, 4000);
                        },
                    },
                    async created() {
                        // console.log("vue here!");
                    },
                });
            </script>
</body>

</html>