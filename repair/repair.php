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
    ?>

    <div id="particles-js"></div>
    <div class="repaircon">

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
                        <input type="text" value="<?php echo isset($row['fname']) ? $row['fname'] : '' ?>" class="form-control" id="fname" name="fname">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname" value="<?php echo isset($row['mname']) ? $row['mname'] : '' ?>">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" value="<?php echo isset($row['lname']) ? $row['lname'] : '' ?>" class="form-control" id="lname" name="lname">
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
                        <input type="email" value="<?php echo isset($row['email']) ? $row['email'] : '' ?>" class="form-control" id="email" name="email">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" value="<?php echo isset($row['phone']) ? $row['phone'] : '' ?>" name="phone"
                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" value="<?php echo isset($row['address']) ? $row['address'] : '' ?>" name="address">
                        <span class="val-error"></span>
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-primary width-50 btn-prev"><i class="fa fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-primary width-50 btn-next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

                <div class="form-step">
                    <div class="mb-3">
                        <label for="etype" class="form-label">Electronic Type</label>
                        <select name="etype" id="etype" class="form-select">
                            <option value="None">--Select--</option>
                            <option value="TV">TV</option>
                            <option value="Refrigerator">Refrigerator</option>
                            <option value="Microwave">Microwave</option>
                            <option value="Aircon">Aircon</option>
                        </select>
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="defective" class="form-label">Defective</label>
                        <input type="text" class="form-control" id="defective" name="defective">
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="shipping" class="form-label">Shipping option</label>
                        <select name="shipping" id="shipping" class="form-select">
                            <option value="None">--Select--</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Deliver">Deliver</option>
                            <option value="Home Service">Home Service</option>
                        </select>
                        <span class="val-error"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eimg">Upload Image (optional)</label>
                        <input type="file" class="form-control" id="eimg" name="eimg" />
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-primary width-50 btn-prev" id="adis"><i class="fa fa-chevron-left"></i></a>
                        <input type="submit" value="SUBMIT" class="btn-submit confirm" name="submit" id="btn-submit">
                    </div>
                </div>
        </form>
    </div>

    <script src="particles.js"></script>
    <script src="app.js"></script>

    <script type="text/javascript">
    $(document).ready(function () {
        $('#btn-submit').click(function (e) {
            e.preventDefault();

            var etype = $('#etype').val();
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

            // Defective validation
            if (defective == "") {
                $('#defective + .val-error').text('Please enter the defect.');
                valid = false;
            } else {
                $('#defective + .val-error').text('');
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
                    success: function (response) {
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

</body>

</html>