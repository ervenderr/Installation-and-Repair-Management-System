<?php
session_start();
if (!isset($_SESSION['logged_id'])) {
    header('location: ../login/login.php');
}


require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
$servreqnav = 'servactives';
include_once('../homeIncludes/header.php');

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);

if(!empty($_POST["service_id"])){
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $sql = "SELECT * FROM package WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo '<option value="None">--Select--</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['pkg_id'] . "'>" . $row['name'] . "</option>";
        }
    }
}


?>

<body>
    <?php
    include_once('../homeIncludes/homenav.php');
    ?>

    <div class="jobcon">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link <?php echo $servpkgnav; ?>" aria-current="page" href="servpkg.php">Packages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $servreqnav; ?>" href="servreq">Service Request</a>
            </li>
            </li>
        </ul>
        <div class="container">
            <div class="pkgcon">

                <form action="servreq.php" class="form" method="POST" id="repair-form" enctype="multipart/form-data">

                    <div id='msgs' class='msg'>
                        <p id='msgs'>Request Submitted!</p>
                        <div class="msgbtn">
                            <a class="msgb" href="../service/service-transaction.php" role="button">Get Information ID</a>
                            <a class="msgb" href="servreq.php" role="button">Submit Another Request</a>

                        </div>
                    </div>

                    <h4 class="text-center">Service Request Form</h3>
                        <!-- progress bar -->

                        <div class="progressbar">
                            <div class="progress" id="progress"></div>
                            <div class="progress-step progress-step-active" data-title="Name"></div>
                            <div class="progress-step" data-title="Contact"></div>
                            <div class="progress-step" data-title="Electronic"></div>
                        </div>

                        <div class="form-step form-step-active">
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" value="name" class="form-control" id="fname" name="fname">
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="mname" name="mname">
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" value="last" class="form-control" id="lname" name="lname">
                                <span class="val-error"></span>
                            </div>
                            <div class="">
                                <a href="#" class="btn btn-primary btn-next width-50 ml-auto"><i
                                        class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="email@dsds.com" class="form-control" id="email" name="email">
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" value="09123456789" name="phone"
                                    pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="ADSDASA" name="address">
                                <span class="val-error"></span>
                            </div>
                            <div class="btns-group">
                                <a href="#" class="btn btn-primary width-50 btn-prev"><i
                                        class="fa fa-chevron-left"></i></a>
                                <a href="#" class="btn btn-primary width-50 btn-next"><i
                                        class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>

                        <div class="form-step">
                            <div class="mb-3">
                                <label for="stype" class="form-label">Service Type</label>
                                <select name="stype" id="stype" class="form-select">
                                    <option value="None">--Select--</option>
                                    <?php
                                        
                                        while($row = mysqli_fetch_assoc($result)) { 
                                            echo "<option value='" . $row['service_id'] . "'>" . $row['service_name'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="package" class="form-label">Package</label>
                                <select name="package" id="package" class="form-select">
                                    <option value="None">--Select--</option>
                                </select>
                                <span class="val-error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="other" class="form-label">Other</label>
                                <input type="text" class="form-control" id="other" value="ADSDASA" name="other">
                            </div>
                            <div class="btns-group">
                                <a href="#" class="btn btn-primary width-50 btn-prev" id="adis"><i
                                        class="fa fa-chevron-left"></i></a>
                                <input type="submit" value="SUBMIT" class="btn-submit confirm" name="submit"
                                    id="btn-submit">
                            </div>
                        </div>
                </form>

            </div>
        </div>
    </div>

    <script src="particles.js"></script>
    <script src="app.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#btn-submit').click(function(e) {
            e.preventDefault();
            var stype = $('#stype').val();

            var valid = true;

            // Electronic Type validation
            if (stype == "None") {
                $('#stype + .val-error').text('Please select a Service.');
                valid = false;
            } else {
                $('#stype + .val-error').text('');
            }


            if (valid) {
                $.ajax({
                    method: "POST",
                    url: "serviceProcess.php",
                    data: $('#repair-form').serialize(),
                    dataType: "text",
                    success: function(response) {
                        $('#msgs').css('display', 'block').fadeIn(300);
                        $('#adis').css('pointer-events', 'none');
                        $('#btn-submit').css('pointer-events', 'none');
                        $('#eimg').css('pointer-events', 'none');
                        $('#shipping').css('pointer-events', 'none');
                    }
                })
            }
        });

        $('#stype').on('change', function(e) {
            var stypeId = e.target.value;
            if (stypeId) {
                $.ajax({
                    method: "POST",
                    url: "servreq.php",
                    data: 'service_id=' + stypeId,
                    success: function(html) {
                        $('#package').html(html);
                    }
                });
            } else {
                $('#package').html('<option value="">--Select--</option>');
            }
        });

    });
    </script>



</body>

</html>