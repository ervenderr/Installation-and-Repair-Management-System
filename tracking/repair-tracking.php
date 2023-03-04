<?php
session_start();

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Tracking';
include_once('../homeIncludes/header.php');

?>

<body class="tracking-body">
    <?php include_once('../homeIncludes/homenav.php');?>


    <div class="container mx-auto tracking-container">
        <div class="card">
            <div class="row d-flex justify-content-between px-3 top">
                <div class="d-flex flex-column col-sm col-md ml-auto">
                    <h5>Transaction number:</h5>
                    <span class="text-primary font-weight-bold">#R3456DF</span>
                </div>
                <div class="d-flex flex-column col-sm col-md flxend">
                    <p class="mb-0">Expected Completion: <span>03/15/23</span></p>
                    <p>Status: <span class="font-weight-bold">Pending</span></p>
                </div>
            </div>

            <!-- Add class 'active' to progress -->
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        <li class="active step0"><br><span>Received</span></li>
                        <li class="step0"><br><span>Diagnosing</span></li>
                        <li class="step0"><br><span>Repairing</span></li>
                        <li class="step0"><br><span>Completed</span></li>
                    </ul>
                </div>
            </div>

            <div class="row px-3 details-req ">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Customer Information</h6>
                    <p><strong>Name:</strong> John Doe</p>
                    <p><strong>Email:</strong> john.doe@example.com</p>
                    <p><strong>Phone:</strong> 123-456-7890</p>
                    <p><strong>Address:</strong> 123 Main St, Anytown USA</p>
                </div>
                <div class="col-md-6 flxend">
                    <h6 class="font-weight-bold">Electronic Information</h6>
                    <p><strong>Electronic Type:</strong> Laptop</p>
                    <p><strong>Defects:</strong> Cracked screen, keyboard not working</p>
                    <p><strong>Shipping:</strong> FedEx Ground</p>
                    <p><strong>Date Requested:</strong> 02/28/23</p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>