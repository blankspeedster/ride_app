<?php
require_once("process_index.php");
$emergency_contact_number = $_SESSION['emergency_contact_number'];
// echo $_SESSION['emergency_contact_number'];
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
                    <h1 class="mt-4">Sample SMS Sending</h1>
                    <h5>Use this Dashboard to check if SMS works in case of emergency</h5>
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
                                    Test SMS
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="phone_number" type="text" placeholder="Phone Number (include aread code)" name="phone_number"
                                                 v-model="phone_number" />
                                                <label for="phone_number">Phone Number</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="sample_message" type="text" placeholder="Sample Message" name="sample_message" v-model="sample_message" />
                                                <label for="sample_message">Sample Message</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <button class="d-grid btn btn-primary btn-block" type="submit" name="register_account" @click.prevent="validateSendSMS" :disabled='isDisabled'>
                                                    {{sendButton}}
                                                </button>
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
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            phone_number: <?php echo $emergency_contact_number; ?>,
                            sample_message: null,
                            apiusername: "APIFB2NQXUV1L",
                            apipassword: "APIFB2NQXUV1LFB2NQ",
                            isDisabled: false,
                            sendButton: "Send Text Message",
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

                        async validateSendSMS(){
                            this.isDisabled = true;
                            this.sendButton = "Message has been sent. Plese check the SMS from your emergency contact.";
                            var _initial_message = "DISCLAIMER: This is just a test message. "+this.sample_message;
                            var _sample_message = encodeURIComponent(_initial_message);
                            var _url = "https://sgateway.onewaysms.com/apis10.aspx";
                            _url = _url+"?apiusername="+this.apiusername;
                            _url = _url+"&apipassword="+this.apipassword;
                            _url = _url+"&mobileno="+this.phone_number;
                            _url = _url+"&senderid=onewaysms";
                            _url = _url+"&message="+_sample_message;
                            _url = _url+"&languagetype=1";

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

                        }
                    },
                    async created() {
                        console.log("vue here!");
                    }
                });
            </script>            
</body>

</html>