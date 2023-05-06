<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Sign Up';
include_once('../homeIncludes/header.php');

?>


<body>
    <?php include_once('../homeIncludes/homenav.php');?>

    <div class="register-photo signups">

        <?php
            if (isset($_SESSION['msg'])) {
                $msg = $_SESSION['msg'];
                echo '<div class="alert alert-success alert-dismissible fade show login-alert" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                '. $msg .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              unset($_SESSION['msg']);
            }
        ?>

        <div class="form-container">
            <form action="mail.php" class="form" method="POST" id="repair-form" enctype="multipart/form-data">
                <h2 class="text-center login-h4"><strong>Sign Up</strong><img class="login-img"
                        src="../img/proton-logo.png" alt=""></h2>
                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Name"></div>
                    <div class="progress-step" data-title="Contact"></div>
                </div>
                <div class="form-step form-step-active">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="fname">First Name</label>
                                <input class="form-control" type="text" name="fname" id="fname" value="Ervens">
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="mname">Middle Name</label>
                                <input class="form-control" type="text" name="mname" id="mname" >
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="lname">Last Name</label>
                                <input class="form-control" type="text" name="lname" id="lname" value="Idjads">
                                <span class="val-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" value="ervenidjad12@gmail.com">
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" value="password">
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group lgns">
                                <label for="password-repeat">Confirm Password</label>
                                <input class="form-control" type="password" name="password-repeat" id="password-repeat" value="password">
                                <span class="val-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group btn-block btn-block2">
                                <a href="#" class="btn btn-primary btn-next width-50 ml-auto btn-block"><i
                                        class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-step">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <label class="form-label" for="address">Street</label>
                                <input class="form-control" id="address" type="text" name="address" value="Sd Street">
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mt-1 mb-2">
                            <div class="">
                                <label class="form-label">Province</label>
                                <select class="form-control select-max" id="province" name="province">
                                    <option value="Basilan">Basilan</option>
                                    <!-- Add more provinces here -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="">
                                <label class="form-label">City/Municipality</label>
                                <select class="form-control" id="city" name="city">
                                    <option value="None">--- Select ---</option>
                                    <!-- City/municipality dropdown options will be populated by javascript based on the selected province -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="">
                                <label class="form-label">Barangay/Village</label>
                                <select class="form-control" id="barangay" name="barangay">
                                    <option value="None">--- Select ---</option>
                                    <!-- Barangay/village dropdown options will be populated by javascript based on the selected city/municipality -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="">
                                <label class="form-label">Phone</label>
                                <input class="form-control" id="phone" type="tel" name="phone" placeholder="Phone" value="09123456789">
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="">
                                <label class="form-label" for="eimg">Profile Image</label>
                                <input type="file" class="form-control" id="eimg" name="eimg" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LckLd4kAAAAAJfBV-ejZXs6CHcYls-rumZZavlU"></div>
                                <span
                                    class="val-error"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group btn-block btn-block2">
                                <a href="#" class="btn btn-primary width-50 btn-prev" id="adis"><i
                                        class="fa fa-chevron-left"></i></a>
                                <input type="submit" value="SUBMIT" class="btn btn-primary btn-submit confirm"
                                    name="submit" id="btn-submit">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="../login/login.php" class="already">You already have an account? Login here.</a>
            </form>


        </div>
    </div>



    <script type="text/javascript">
    $(document).ready(function() {
        $('#repair-form').submit(function(event) {
            var address = $('#address').val();
            var phone = $('#phone').val();
            var password = $('input[name="password"]').val();
            var passwordRepeat = $('input[name="password-repeat"]').val();
            var valid = true;

            // Check if reCAPTCHA is checked
            if (!$('.g-recaptcha-response').val()) {
                $('.val-error').text('Please check the reCAPTCHA box');
                valid = false;
            } else {
                $('.val-error').text('');
            }

            // Address validation
            if (address == "") {
                $('#address + .val-error').text('Please enter your address.');
                valid = false;
            } else {
                $('#address + .val-error').text('');
            }

            // Phone number validation
            if (phone == "") {
                $('#phone + .val-error').text('Please enter your phone number.');
                valid = false;
            } else {
                $('#phone + .val-error').text('');
            }

            // Password validation
            if (password.length < 8) {
                $('input[name="password"] + .val-error').text(
                    'Password must be at least 8 characters long.');
                valid = false;
            } else {
                $('input[name="password"] + .val-error').text('');
            }

            // Repeat password validation
            if (password != passwordRepeat) {
                $('input[name="password-repeat"] + .val-error').text('Passwords do not match.');
                valid = false;
            } else {
                $('input[name="password-repeat"] + .val-error').text('');
            }

            // Submit the form if all fields are valid
            if (!valid) {
                event.preventDefault(); // Prevent the form from being submitted if validation fails
            }
        });
    });
    </script>

    <script>
    const provinces = [{
            "ID": "001",
            "Type": "City of Lamitan",
            "Barangays": [
                "Arco",
                "Baimbing",
                "Balagtasan",
                "Balanting",
                "Bohe Lebbung",
                "Bohe-Suyak",
                "Calugusan",
                "Colonia",
                "Limo-ok",
                "Luksumbang",
                "Maganda",
                "Matibay",
                "Parangbasak",
                "Sengal",
                "Tandung Ahas",
                "Ulame",
                "Colonia-Lamitan"
            ]
        },
        {
            "ID": "002",
            "Type": "Isabela City",
            "Barangays": [
                "Baluno",
                "Begang",
                "Binuangan",
                "Busay",
                "Cabunbata",
                "Calsada",
                "Carbon",
                "City Heights",
                "Kaumpurnah Zone I",
                "Kaumpurnah Zone II",
                "Kaumpurnah Zone III",
                "Kaumpurnah Zone IV",
                "Kumalarang",
                "La Piedad",
                "Lampinigan Island",
                "Maligue",
                "Marang-marang",
                "Masula",
                "Panigayan",
                "Port Area",
                "Riverside",
                "San Rafael",
                "Santa Barbara",
                "Seaside",
                "Small Kapatagan",
                "Sumagdang",
                "Tabuk",
                "Tampalan",
                "Tapiantana",
                "Begang Proper",
                "Kanaway"
            ]
        }
    ];

    // Populate the city dropdown with the cities from the JSON data
    provinces.forEach((province) => {
        $("#city").append(`<option value="${province.ID}">${province.Type}</option>`);
    });

    // On city change, populate the barangay dropdown
    $("#city").on("change", function() {
        const cityID = $(this).val();
        const province = provinces.find((province) => province.ID === cityID);

        // Clear the barangay dropdown and add the default option
        $("#barangay").empty().append(`<option value="None">--- Select ---</option>`);

        if (province) {
            // Populate the barangay dropdown with the barangays from the selected city
            province.Barangays.forEach((barangay) => {
                $("#barangay").append(`<option value="${barangay}">${barangay}</option>`);
            });
        }
    });
    </script>
</body>

</html>