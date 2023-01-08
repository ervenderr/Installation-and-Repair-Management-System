<?php
require_once 'homeIncludes/dbconfig.php';

require_once 'tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$repair = 'actives';
include_once('homeIncludes/header.php');


?>

<body class="repairbody">

    <?php include_once('homeIncludes/homenav.php'); ?>

    <div class="container servicecon repaircon">
        <form action="#" class="form">
            <h4 class="text-center">Repair Reqeust Form</h3>

                <!-- progress bar -->

                <div class="progressbar">
                    <div class="progress" id="progress"></div>

                    <div class="progress-step progress-step-active" data-title="Name"></div>
                    <div class="progress-step" data-title="Contact"></div>
                    <div class="progress-step" data-title="Electronic"></div>
                    <div class="progress-step" data-title="Submitted"></div>
                </div>

                <div class="form-step form-step-active">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname">
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
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
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
                    </div>
                    <div class="mb-3">
                        <label for="defective" class="form-label">Defective</label>
                        <input type="text" class="form-control" id="defective" name="defective"
                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                    </div>
                    <div class="mb-3">
                        <label for="shipping" class="form-label">Shipping option</label>
                        <select name="shipping" id="shipping" class="form-select">
                            <option value="None">--Select--</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Deliver">Deliver</option>
                            <option value="Home Service">Home Service</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eimg">Upload Image (optional)</label>
                        <input type="file" class="form-control" id="eimg" name="eimg "/>
                    </div>
                    <div class="btns-group">
                        <a href="#" class="btn btn-primary width-50 btn-prev"><i class="fa fa-chevron-left"></i></a>
                        <input type="submit" value="SUBMIT" class="btn">
                    </div>
                </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>