<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'technician'){
  header('location: ../login/login.php');
}else{
  $user_id = $_SESSION['logged_id'];
}

?>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include_once('../technician_includes/navbar.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('../technician_includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon text-white me-2">
                <i class="fas fa-home menu-icon"></i>
                </span> 
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-c-pink card-img-holder text-white">
                  <div class="card-body">

                  <?php
$result = mysqli_query($conn, "SELECT COUNT(*) FROM rprq WHERE status = 'Completed'");
$count = mysqli_fetch_array($result)[0];
                    ?>
                    
                    <h4 class="font-weight-normal mb-3">Completed Request <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo $count; ?></h2>
                    <h6 class="card-text">Increased by 100%</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-c-blue card-img-holder text-white">
                  <div class="card-body">
                  <?php
$result2 = mysqli_query($conn, "SELECT COUNT(*) FROM rprq WHERE DATE(date_req) = DATE(NOW())");
$count2 = mysqli_fetch_array($result2)[0];
                    ?>

                    
                    <h4 class="font-weight-normal mb-3">Repair Request Today <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"><?php echo $count2; ?></h2>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © protontech.com 2023</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a href="https://www.proton-tech.online/" target="_blank">ProtonTech</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
