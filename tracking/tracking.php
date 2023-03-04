<?php
session_start();

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Tracking';
include_once('../homeIncludes/header.php');

?>

<body class="track">
    <?php include_once('../homeIncludes/homenav.php');?>
    <div class="container tracking">
        <div class="row height d-flex justify-content-center">
            <div class="col-md-8 tracking-width">
                <div class="search tracking-row">
                    <i class="fa fa-search"></i>
                    <input type="text" class="form-control" placeholder="Enter your Transaction number">
                    <button class="btn btn-primary">Search</button>
                </div>

            </div>

        </div>
    </div>


</body>

</html>