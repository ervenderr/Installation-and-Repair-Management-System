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
                        <div class="col-md-5 col-sm-12 stretch-card grid-margin">
                            <div class="card bg-c-pink card-img-holder text-white">
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
                                    <h4 class="font-weight-normal mb-3">Weekly Repair Request <i
                                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $current_count; ?></h2>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 stretch-card grid-margin">
                            <div class="card bg-c-blue card-img-holder text-white">
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

                                    <h4 class="font-weight-normal mb-3">Weekly Service Request <i
                                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $current_count2; ?></h2>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 stretch-card grid-margin">
                            <div class="card bg-c-yellow card-img-holder text-white">
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
                                    <h4 class="font-weight-normal mb-3">Pending Repair Request <i
                                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                                    </h4>
                                    <h2 class="mb-5"><?php echo $count; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 stretch-card grid-margin">
                            <div class="card bg-c-green card-img-holder text-white">
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
                                    <div class="sales-report-header d-flex justify-content-between align-items-center">
                                        <h4 class="sales-report-title">Sales report</h4>
                                        <div class="filter d-flex align-items-center">
                                            <span class="by">By: </span>
                                            <select id="timeFilter" class="form-select sales-filter">
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
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
    async function fetchSalesData(timeFilter) {
        const response = await fetch(`fetch_sales_data.php?timeFilter=${timeFilter}`);
        const salesData = await response.json();
        return salesData;
    }

    async function renderSalesChart(timeFilter) {
        const salesData = await fetchSalesData(timeFilter);

const numPeriods = timeFilter === 'weekly' ? 7 : 
                  timeFilter === 'monthly' ? 12 : 
                  timeFilter === 'daily' ? 24 :
                  Object.keys(salesData).length;

const getDailyLabels = () => {
    const currentDate = new Date();
    const labels = [];

    for (let i = 0; i < numPeriods; i++) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() + i);
        const options = { month: 'short', day: 'numeric' };
        const formattedDate = date.toLocaleDateString('en-US', options);
        labels.push(formattedDate);
    }

    return labels;
}

const labels = {
    weekly: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    monthly: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December'
    ],
    yearly: Object.keys(salesData),
    daily: getDailyLabels(),
};


        const repairData = [];
        const serviceData = [];

        if (timeFilter === 'daily') {
            for (let i = 0; i < numPeriods; i++) {
                const salesForPeriod = salesData[i] || {
                    repair: 0,
                    service: 0
                };
                repairData.push(salesForPeriod.repair);
                serviceData.push(salesForPeriod.service);
            }
        } else {
            for (let i in salesData) {
                repairData.push(salesData[i].repair);
                serviceData.push(salesData[i].service);
            }
        }

        const salesChartData = {
            labels: labels[timeFilter],
            datasets: [{
                label: 'Repair Request Sales',
                data: repairData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }, {
                label: 'Service Request Sales',
                data: serviceData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }],
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

    // Add an event listener for the time filter dropdown
    document.getElementById('timeFilter').addEventListener('change', (event) => {
        const timeFilter = event.target.value;
        renderSalesChart(timeFilter);
    });

    // Call the initial render with the default time filter
    renderSalesChart('daily');
    </script>




</body>

</html>