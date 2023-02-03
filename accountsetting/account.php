<?php
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = '';
include_once('../homeIncludes/header.php');





?>

<body>
    <?php include_once('../homeIncludes/homenav.php');?>

    <div class="accountcon">
        <h1 class="text-center my-4">My Account Details</h1>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 sidebar">
                    <div class="accon d-flex align-items-center">
                        <img src="https://via.placeholder.com/50x50" alt="Customer Image" class="mr-3">
                        <h5 class="pt-3 mb-0">Customer Name</h5>
                    </div>
                    <div>
                        <a href="#">Repair request</a>
                    </div>
                    <div>
                        <a href="#">Service request</a>
                    </div>
                    <div>
                        <a href="#">Account setting</a>
                    </div>
                    <div>
                        <a href="#">Logout</a>
                    </div>
                </div>
                <div class="col-sm-9 accform-container">
                    <form class="accform">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


</body>

</html>