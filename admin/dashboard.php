<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login/login.php');
}

?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once('../admin_includes/navbar.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once('../admin_includes/sidebar.php'); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                                <i class="fas fa-home menu-icon"></i>
                            </span> Dashboard
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Overview <i
                                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white">
                                <div class="card-body">
                                    <?php
                    // Query for current week's count
                    $sql_current = "SELECT COUNT(*) AS count FROM rprq WHERE date_req >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                    $result_current = $conn->query($sql_current);

                    if ($result_current->num_rows > 0) {
                        while($row = $result_current->fetch_assoc()) {
                            $current_count = $row["count"];
                        }
                    } else {
                        $current_count = 0;
                    }

                    // Query for previous week's count
                    $sql_previous = "SELECT COUNT(*) AS count FROM rprq WHERE date_req BETWEEN DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                    $result_previous = $conn->query($sql_previous);

                    if ($result_previous->num_rows > 0) {
                        while($row = $result_previous->fetch_assoc()) {
                            $previous_count = $row["count"];
                        }
                    } else {
                        $previous_count = 0;
                    }

                    // Calculate percentage increase/decrease
                    if ($previous_count > 0) {
                        $percentage_change = (($current_count - $previous_count) / $previous_count) * 100;
                    } else {
                        $percentage_change = 0;
                    }
                    ?>
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                        alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Weekly Repair Request <i
                                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $current_count; ?></h2>
                                    <h6 class="card-text">
                                        <?php printf("%s by %.2f%%", $current_count >= $previous_count ? "Increased" : "Decreased", abs($percentage_change)); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white">
                                <div class="card-body">
                                    <?php
    $sql_current2 = "SELECT COUNT(*) AS count FROM service_request WHERE date_req >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    $result_current2 = $conn->query($sql_current2);

    if ($result_current2->num_rows > 0) {
        while($row2 = $result_current2->fetch_assoc()) {
            $current_count2 = $row2["count"];
        }
    } else {
        $current_count2 = 0;
    }

    // Query for previous week's count
    $sql_previous2 = "SELECT COUNT(*) AS count FROM service_request WHERE date_req BETWEEN DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    $result_previous2 = $conn->query($sql_previous2);

    if ($result_previous2->num_rows > 0) {
        while($row2 = $result_previous2->fetch_assoc()) {
            $previous_count2 = $row2["count"];
        }
    } else {
        $previous_count2 = 0;
    }

    // Calculate percentage increase/decrease
    if ($previous_count2 > 0) {
        $percentage_change2 = (($current_count2 - $previous_count2) / $previous_count2) * 100;
    } else {
        $percentage_change2 = 0;
    }
?>

                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                        alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Weekly Service Request <i
                                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $current_count2; ?></h2>
                                    <h6 class="card-text">
                                        <?php printf("%s by %.2f%%", $current_count2 >= $previous_count2 ? "Increased" : "Decreased", abs($percentage_change2)); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">
                                <div class="card-body">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                        alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Total Sales <i
                                            class="mdi mdi-diamond mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5">$ 95,5741</h2>
                                    <h6 class="card-text">Increased by 5%</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-warning card-img-holder text-white">
                                <div class="card-body">
                                    <?php
                    $sql = "SELECT COUNT(*) AS count FROM rprq WHERE status = 'Pending'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          $count = $row["count"];
                      }
                  } else {
                      $count = 0;
                  }
                    ?>
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                        alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Pending Repair Request <i
                                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $count; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-primary card-img-holder text-white">
                                <div class="card-body">
                                    <?php
                    $sql = "SELECT COUNT(*) AS count FROM service_request WHERE status = 'Pending'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          $count2 = $row["count"];
                      }
                  } else {
                      $count2 = 0;
                  }
                    ?>
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                        alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">Pending Service Request <i
                                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $count2; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <h4 class="card-title float-left">Sales report</h4>
                                    </div>
                                    <canvas id="salesChart" width="400" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid d-flex justify-content-between">
                        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
                            protontech.com 2023</span>
                        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a
                                href="https://www.proton-tech.online/" target="_blank">ProtonTech</a></span>
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


    <script>
    async function fetchSalesData() {
        const response = await fetch('fetch_sales_data.php');
        const salesData = await response.json();
        return salesData;
    }

    async function renderSalesChart() {
        const salesData = await fetchSalesData();

        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        const repairData = [];
        const serviceData = [];

        for (let i = 1; i <= 12; i++) {
            repairData.push(salesData[i].repair);
            serviceData.push(salesData[i].service);
        }

        const salesChartData = {
            labels: labels,
            datasets: [{
                    label: 'Repair Request Sales',
                    data: repairData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Service Request Sales',
                    data: serviceData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
            ],
        };

        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: salesChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    renderSalesChart();
    </script>

</body>

</html>