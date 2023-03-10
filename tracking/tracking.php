<?php
session_start();

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Tracking';
include_once('../homeIncludes/header.php');

?>

<body class="track">
    <?php include_once('../homeIncludes/homenav.php');?>
    <img src="../img/rp2.jpg" alt="repair-bg" class="bg-search">
    <div class="container tracking">
        <div class="row height d-flex justify-content-center">
            <div class="col-md-8 tracking-width">
                <?php
                    if (isset($_SESSION['error'])) {
                        $msg =  $_SESSION['error'];
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        '. $msg .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                      unset ($_SESSION['error']);
                    }
                ?>
                <h3 class="text-center text-white">Track your request</h3>
                <form action="repair-tracking.php" method="get">
                    <div class="search tracking-row">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Enter your Transaction number">
                        <button class="btn btn-primary btn-search">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>