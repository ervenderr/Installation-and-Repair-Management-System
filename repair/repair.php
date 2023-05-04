<?php
session_start();

if (!isset($_SESSION['logged_id']) && !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'customer') {
    header('location: ../login/login.php');
}

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$repair = 'actives activess';
require_once '../homeIncludes/header.php';


$user_id = $_SESSION['logged_id'];

$sql = "SELECT *
FROM accounts 
INNER JOIN customer ON accounts.account_id = customer.account_id
WHERE accounts.account_id = $user_id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$_SESSION["cust_id"] = $row["cust_id"];
?>

<body class="repairbody">

    <?php
    require_once '../homeIncludes/homenav.php';
    require_once '../modals/repair-process.php';
    ?>

    <div id="particles-js"></div>
    <div class="repaircon">

        <button type="button" class="btn btn-primary btn-faq" data-bs-toggle="modal" data-bs-target="#rprocess">
            ?
        </button>
        <form action="repair.php" class="form" method="POST" id="repair-form" enctype="multipart/form-data">

            <div id='msgs' class='msg'>
                <p id='msgs'>Request Submitted!</p>
                <div class="msgbtn">
                    <a class="msgb" href="../repair/pending-transaction.php" role="button">Get Information ID</a>
                    <a class="msgb" href="repair.php" role="button">Submit Another Request</a>

                </div>
            </div>

            <h4 class="text-center">Repair Request Form</h3>



                <!-- progress bar -->

                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Name"></div>
                    <div class="progress-step" data-title="Contact"></div>
                    <div class="progress-step" data-title="Electronic"></div>
                </div>

                <div class="form-step form-step-active">
                    <div class="mb-3">
                        <label for="fname" class="form-label labls">First Name</label>
                        <input type="text" value="<?php echo isset($row['fname']) ? $row['fname'] : '' ?>"
                            class="form-control" id="fname" name="fname">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" style="color: lightgrey" id="mname" name="mname"
                            value="<?php echo isset($row['mname']) ? $row['mname'] : ''; ?>(Optional)">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" value="<?php echo isset($row['lname']) ? $row['lname'] : '' ?>"
                            class="form-control" id="lname" name="lname">
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
                        <input type="email" value="<?php echo isset($row['email']) ? $row['email'] : '' ?>"
                            class="form-control" id="email" name="email">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone"
                            value="<?php echo isset($row['phone']) ? $row['phone'] : '' ?>" name="phone"
                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address"
                            value="<?php echo isset($row['address']) ? $row['address'] : '' ?>" name="address">
                        <span class="val-error"></span>
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-primary width-50 btn-prev"><i class="fa fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-primary width-50 btn-next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

                <div class="form-step">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="etype" class="form-label">Electronic Type</label>
                                <select name="etype" id="etype" class="form-control">
                                    <option value="None">--- Select ---</option>
                                    <?php
                                    $sql = "SELECT * FROM electronics";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)) { 
                                        echo "<option value='" . $row['elec_id'] . "'>" . $row['elec_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categname" class="form-label">Subcategory</label>
                                <select name="categname" id="categname" class="form-select">
                                    <option value="None">--- Select ---</option>

                                </select>
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ebrand" class="form-label">Brand</label>
                                <select name="ebrand" id="ebrand" class="form-control">
                                    <option value="None">--Select--</option>
                                    <!-- Options will be populated using JavaScript/jQuery -->
                                    <option value="other">Other</option>
                                </select>
                                <span class="val-error"></span>
                            </div>
                            <div class="form-group" id="other-brand-input" style="display:none;">
                                <label for="other_brand" class="col-form-label">Other Brand</label>
                                <input type="text" name="other_brand" id="other_brand" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="defective" class="col-form-label">Defects</label>
                                <div class="">
                                    <select name="defective" id="defective" class="form-control">
                                        <option value="None">--- Select ---</option>
                                        <!-- Options will be populated using JavaScript/jQuery -->
                                        <option value="other">Other</option>
                                    </select>
                                    <span class="val-error"></span>
                                </div>
                                <div class="form-group" id="other-defect-input" style="display:none;">
                                    <label for="other_defective" class="col-form-label">Other Defect</label>
                                    <input type="text" name="other_defective" id="other_defective" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 mt-1">
                                <label for="shipping" class="form-label">Shipping option</label>
                                <select name="shipping" id="shipping" class="form-select">
                                    <option value="None">--Select--</option>
                                    <option value="Pickup">Pickup</option>
                                    <option value="Deliver">Deliver</option>
                                    <option value="Home Service">Home Service</option>
                                </select>
                                <span class="val-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="eimg">Upload Image (optional)</label>
                                <input type="file" class="form-control" id="eimg" name="eimg" />
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tech" class="form-label">Select Technician (optional)</label>
                        <select name="tech" id="tech" class="form-control">
                            <option value="None">--- Any ---</option>
                            <?php
                                    $sql = "SELECT * FROM technician";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)) { 
                                        echo "<option value='" . $row['tech_id'] . "'>" . $row['fname'] . '  ' . $row['lname'] . "</option>";
                                    }
                                    ?>
                        </select>
                        <span class="val-error"></span>
                    </div>
                </div>
                <div class="btns-group">
                    <a href="#" class="btn btn-primary width-50 btn-prev" id="adis"><i
                            class="fa fa-chevron-left"></i></a>
                    <input type="submit" value="SUBMIT" class="btn-submit confirm" name="submit" id="btn-submit">
                </div>
    </div>
    </form>
    </div>

    <script src="particles.js"></script>
    <script src="app.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#btn-submit').click(function(e) {
            e.preventDefault();

            var etype = $('#etype').val();
            var ebrand = $('#ebrand').val();
            var categname = $('#categname').val();
            var defective = $('#defective').val();
            var shipping = $('#shipping').val();
            var eimg = $('#eimg').val();
            var valid = true;

            // Electronic Type validation
            if (etype == "None") {
                $('#etype + .val-error').text('Please select an electronic type.');
                valid = false;
            } else {
                $('#etype + .val-error').text('');
            }

            // Brand validation
            if (ebrand == "None") {
                $('#ebrand ~ .val-error').text('Please select a brand.');
                valid = false;
            } else {
                $('#ebrand ~ .val-error').text('');
            }

            // subcateg validation
            if (categname == "None") {
                $('#categname ~ .val-error').text('Please select a subcategory.');
                valid = false;
            } else {
                $('#categname ~ .val-error').text('');
            }

            // Defective validation
            if (defective == "None") {
                $('#defective ~ .val-error').text('Please enter the defect.');
                valid = false;
            } else {
                $('#defective ~ .val-error').text('');
            }

            // Shipping option validation
            if (shipping == "None") {
                $('#shipping + .val-error').text('Please select a shipping option.');
                valid = false;
            } else {
                $('#shipping + .val-error').text('');
            }


            if (valid) {
                $.ajax({
                    method: "POST",
                    url: "repairProcess.php",
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
    });
    </script>

    <script>
    document.getElementById('defective').addEventListener('change', function() {
        if (this.value === 'other') {
            document.getElementById('other-defect-input').style.display = 'block';
        } else {
            document.getElementById('other-defect-input').style.display = 'none';
        }
    });

    document.getElementById('ebrand').addEventListener('change', function() {
        if (this.value === 'other') {
            document.getElementById('other-brand-input').style.display = 'block';
        } else {
            document.getElementById('other-brand-input').style.display = 'none';
        }
    });
    </script>

    z<script>
    $(document).ready(function() {
        $('#etype').change(function() {
            var etype_id = $(this).val();

            if (etype_id === "None") {
                $('#defective').html('<option value="None">--- Select ---</option>');
            } else {
                $.ajax({
                    url: 'fetch_defects.php',
                    type: 'POST',
                    data: {
                        etype_id: etype_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="None">--- Select ---</option>' +
                            '<option value="other">Other</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].defect_id + '">' + data[
                                    i]
                                .defect_name + '</option>';

                        }
                        $('#defective').html(options);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });

        $('#etype').change(function() {
            var etype_id = $(this).val();

            if (etype_id === "None") {
                $('#ebrand').html('<option value="None">--- Select ---</option>');
            } else {
                $.ajax({
                    url: 'fetch_brands.php',
                    type: 'POST',
                    data: {
                        etype_id: etype_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="None">--- Select ---</option>' +
                            '<option value="other">Other</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].eb_id + '">' + data[i]
                                .eb_name + '</option>';
                        }
                        console.log(data)
                        $('#ebrand').html(options);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });

        $('#etype').change(function() {
            var etype_id = $(this).val();

            if (etype_id === "None") {
                $('#categname').html('<option value="None">--- Select ---</option>');
            } else {
                $.ajax({
                    url: 'get_subcateg.php',
                    type: 'POST',
                    data: {
                        etype_id: etype_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="None">--- Select ---</option>';
                        for (var i = 0; i < data.length; i++) {
                            options += '<option value="' + data[i].elec_sub_categ_id + '">' + data[
                                    i]
                                .subcateg_name + '</option>';

                        }
                        $('#categname').html(options);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
    </script>


</body>

</html>