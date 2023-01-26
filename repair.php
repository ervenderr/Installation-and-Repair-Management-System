<?php
require_once 'homeIncludes/dbconfig.php';
require_once 'tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$repair = 'actives activess';
include_once('homeIncludes/header.php');
?>

<body class="repairbody">

    <?php
    include_once('homeIncludes/homenav.php');
    ?>

<?php
if(isset($_POST['submit'])) {
    $fname = htmlentities($_POST['fname']);
    $mname = htmlentities($_POST['mname']);
    $lname = htmlentities($_POST['lname']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities( $_POST['phone']);
    $address = htmlentities($_POST['address']);
    if(isset($_POST['etype'])){
        $etype = $_POST['etype'];
    }
    $defective = htmlentities($_POST['defective']);
    $shipping = $_POST['shipping'];
    if(!empty($_FILES['eimg']['name'])){
        $filename = $_FILES['eimg']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
        if(in_array($filetype,$allowedtypes)){
            $image = $_FILES['eimg']['tmp_name'];
            $imgcontent = addslashes(file_get_contents($image));
        }
    }

    $query = "INSERT INTO repair_request (fname, mname, lname, email, phone, address, etype, defective, shipping, image) VALUES ('$fname', '$mname', '$lname', '$email', '$phone', '$address', '$etype', '$defective', '$shipping', '".$imgcontent."')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Repair request submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

    <div id="particles-js"></div>
    <div class="repaircon">

        <form action="repair.php" class="form" method="POST" id="repair-form" enctype="multipart/form-data">
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
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname">
                        <span></span>
                    </div>
                    <div class="">
                        <a href="#" class="btn btn-primary btn-next width-50 ml-auto"><i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

                <div class="form-step">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                            <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <span></span>
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
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="defective" class="form-label">Defective</label>
                        <input type="text" class="form-control" id="defective" name="defective">
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label for="shipping" class="form-label">Shipping option</label>
                        <select name="shipping" id="shipping" class="form-select">
                            <option value="None">--Select--</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Deliver">Deliver</option>
                            <option value="Home Service">Home Service</option>
                        </select>
                        <span></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eimg">Upload Image (optional)</label>
                        <input type="file" class="form-control" id="eimg" name="eimg"/>
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-primary width-50 btn-prev"><i class="fa fa-chevron-left"></i></a>
                        <input type="submit" value="SUBMIT" class="btn-submit confirm" name="submit" id="btn-submit">
                    </div>
                </div>
        </form>
    </div>
    

    <script src="particles.js"></script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>