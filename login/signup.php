<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Sign Up';
include_once('../homeIncludes/header.php');

?>


<body>
    <?php include_once('../homeIncludes/homenav.php');?>
    <div class="register-photo">

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
            <form action="signup-process.php" class="form" method="POST" id="repair-form" enctype="multipart/form-data">
                <h2 class="text-center login-h4"><strong>Sign Up</strong><img class="login-img"
                        src="../img/proton-logo.png" alt=""></h2>
                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Name"></div>
                    <div class="progress-step" data-title="Contact"></div>
                    <div class="progress-step" data-title="Electronic"></div>
                </div>
                <div class="form-step form-step-active">
                    <div class="form-group lgns"><input class="form-control" type="text" name="fname"
                            placeholder="First Name">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><input class="form-control" type="text" name="mname"
                            placeholder="Middle Name">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><input class="form-control" type="text" name="lname"
                            placeholder="Last Name">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group btn-block btn-block2">
                        <a href="#" class="btn btn-primary btn-next width-50 ml-auto btn-block"><i
                                class="fa fa-chevron-right"></i></a>
                    </div><a href="../login/login.php" class="already">You already have an account? Login here.</a>
                </div>

                <div class="form-step">
                    <div class="form-group lgns"><input class="form-control" type="email" name="email"
                            placeholder="Email">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><input class="form-control" type="password" name="password"
                            placeholder="Password">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><input class="form-control" type="password" name="password-repeat"
                            placeholder="Confirm password">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group btn-block btn-block2">
                        <a href="#" class="btn btn-primary width-50 btn-prev"><i class="fa fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-primary width-50 btn-next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="form-step">
                    <div class="form-group lgns"><input class="form-control" id="phone" type="tel" name="phone"
                            placeholder="Phone">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><input class="form-control" id="address" type="text" name="address"
                            placeholder="Address">
                        <span class="val-error"></span>
                    </div>
                    <div class="form-group lgns"><label class="form-label" for="eimg">Profile Image</label>
                        <input type="file" class="form-control" id="eimg" name="eimg" />
                    </div>

                    <div class="form-group lgns">
                        <div class="g-recaptcha" data-sitekey="6LckLd4kAAAAAJfBV-ejZXs6CHcYls-rumZZavlU"></div>
                        <span class="val-error"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></span>
                    </div>

                    <div class="form-group btn-block btn-block2">
                        <a href="#" class="btn btn-primary width-50 btn-prev" id="adis"><i
                                class="fa fa-chevron-left"></i></a>
                        <input type="submit" value="SUBMIT" class="btn btn-primary btn-submit confirm" name="submit"
                            id="btn-submit">
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#btn-submit').click(function() {
            var address = $('#address').val();
            var phone = $('#phone').val();
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

            // Submit the form if all fields are valid
            if (valid) {
                // The default form submission behavior will submit the form to "signup-process.php"
            }
        });
    });
    </script>
</body>

</html>