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
                <div class="content-wrapper report-content">
                    <div class="page-header report-header">
                        <ul class="nav nav-pills nav-justified report-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="reports.php">Repair Sales
                                    Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="services-reports.php">Services Sales Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="backlogs.php">Backlogs / Cancelled</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-reports.php">Products</a>
                            </li>
                        </ul>
                    </div>
                    <?php
                        // Total sales today
                        $sql_today = "SELECT SUM(payment) as total FROM rprq WHERE DATE(date_completed) = CURDATE() AND status='Completed'";
                        $result_today = $conn->query($sql_today);
                        $salesToday = $result_today->fetch_assoc()['total'] ?? 0;

                        // Total sales this month
                        $sql_month = "SELECT SUM(payment) as total FROM rprq WHERE YEAR(date_completed) = YEAR(CURRENT_DATE()) AND MONTH(date_completed) = MONTH(CURRENT_DATE()) AND status='Completed'";
                        $result_month = $conn->query($sql_month);
                        $salesThisMonth = $result_month->fetch_assoc()['total'] ?? 0;

                        // Total sales this year
                        $sql_year = "SELECT SUM(payment) as total FROM rprq WHERE YEAR(date_completed) = YEAR(CURRENT_DATE()) AND status='Completed'";
                        $result_year = $conn->query($sql_year);
                        $salesThisYear = $result_year->fetch_assoc()['total'] ?? 0;

                        // Total completed request
                        $sql_completed = "SELECT COUNT(*) as total FROM rprq WHERE status='Completed'"; // Adjust this query based on your criteria for a completed request
                        $result_completed = $conn->query($sql_completed);
                        $totalCompleted = $result_completed->fetch_assoc()['total'] ?? 0;
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex text-center">
                                    <h4 class="card-title">Repair Sales Report</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xl-3">
                                    <div class="card bg-c-blue order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Sales Today</h6>
                                            <h2 class="text-right"><span><?php echo $salesToday; ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xl-3">
                                    <div class="card bg-c-green order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Sales This Month</h6>
                                            <h2 class="text-right"><?php echo $salesThisMonth; ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xl-3">
                                    <div class="card bg-c-yellow order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Total Sales This Year</h6>
                                            <h2 class="text-right"><i
                                                    class="fa fa-refresh f-left"></i><span><?php echo $salesThisYear; ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xl-3">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h6 class="m-b-20">Completed Request</h6>
                                            <h2 class="text-right"><span><?php echo $totalCompleted; ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="xpt" id="exportExcel">Export to
                                            Excel</button>
                                        <button type="button" class="xpt" id="exportPdf">Export to
                                            PDF</button>
                                    </div>
                                </div>
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive text-center">
                                        
                                        <table id="myDataTable" class="table table-hover">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> YEAR </th>
                                                    <th> JAN </th>
                                                    <th> FEB </th>
                                                    <th> MAR </th>
                                                    <th> APR </th>
                                                    <th> MAY </th>
                                                    <th> JUN </th>
                                                    <th> JUL </th>
                                                    <th> AUG </th>
                                                    <th> SEP </th>
                                                    <th> OCT </th>
                                                    <th> NOV </th>
                                                    <th> DEC </th>
                                                    <th> TOTAL </th>
                                                </tr>
                                            </thead>
                                            <?php
                            $sql = "SELECT EXTRACT(YEAR FROM date_completed) as year, EXTRACT(MONTH FROM date_completed) as month, SUM(payment) as total FROM rprq WHERE status = 'Completed' GROUP BY EXTRACT(YEAR FROM date_completed), EXTRACT(MONTH FROM date_completed) ORDER BY EXTRACT(YEAR FROM date_completed), EXTRACT(MONTH FROM date_completed)";
                            $result = $conn->query($sql);
                            $salesData = [];
                            $totalSales = array_fill_keys(range(2023, date('Y')), 0); // Initialize an array with all years between 2023 and current year, and set the total sales for each year to 0.
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $year = $row["year"];
                                    $month = $row["month"];
                                    $sales = $row["total"];
                                    $salesData[$year][$month] = $sales;
                                    $totalSales[$year] += $sales; // Add the sales for each month to the total sales for the year.
                                }
                            }
                        ?>
                                            <tbody id="myTable">
                                                <?php
                                $startYear = 2023; 
                                $endYear = date('Y'); 
                                foreach(range($startYear, $endYear) as $year) {
                                    echo "<tr>";
                                    echo "<td>$year</td>";
                                    $total = 0;
                                    foreach(range(1, 12) as $month) {
                                        $sales = isset($salesData[$year][$month]) ? $salesData[$year][$month] : 0;
                                        echo "<td>$sales</td>";
                                        $total += $sales;
                                    }
                                    echo "<td>$total</td>";
                                    echo "</tr>";
                                }
                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card report-card-two">
                        <div class="card-body">
                            <h4 class="card-title text-center">Repair Transaction Record</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="xpt" id="exportExcel2">Export to
                                            Excel</button>
                                        <button type="button" class="xpt" id="exportPdf2">Export to
                                            PDF</button>
                                    </div>
                                </div>
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive text-center">

                                        <table class="table table-hover" id="myDataTable2">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> TRANSACTION ID </th>
                                                    <th> TYPE </th>
                                                    <th> DATE </th>
                                                    <th> STATUS </th>
                                                    <th> TOTAL </th>
                                                    <th> ACTION </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable2">
                                                <?php
                                            $sql_all = "SELECT * FROM rprq
                                            LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                                            WHERE status='Completed' ORDER BY date_completed DESC";
                                            $result_all = $conn->query($sql_all);
                                            if ($result_all->num_rows > 0) {
                                                $count = 1;
                                                while ($row = $result_all->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $count . "</td>";
                                                    echo "<td>" . $row["transaction_code"] . "</td>"; 
                                                    echo "<td>" . $row["type"] . "</td>"; 
                                                    echo "<td>" . $row["date_completed"] . "</td>"; 
                                                    echo "<td>" . $row["status"] . "</td>"; 
                                                    echo "<td>" . $row["payment"] . "</td>"; 
                                                    echo '<td>';
                                                    echo '<a class="icns" href="../adminRepair/view-transaction.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['id'] . '">';
                                                    echo '<i class="fas fa-eye text-white view-accoun view" data-rowid="' .  $row['id'] . '"></i>';
                                                    echo '</a>';
                                                    echo '</td>';
                                                    echo "</tr>";
                                                    $count++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No data found</td></tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include_once('../modals/add-customer-modal.php') ?>
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
    // Add an event listener to the eye icon to show the modal window
    const viewAccountIcons = document.querySelectorAll('.view-account');
    viewAccountIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const rowid = icon.getAttribute('data-rowid');
            const modal = new bootstrap.Modal(document.getElementById('accountModal'));
            modal.show();
            // TODO: Populate the account form with data from the rowid
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#myInput2").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable2 tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        j(document).ready(function() {
            // filter by date range
            var table = j('#myDataTable').DataTable();

            j('#filterBtn').click(function() {
                var startDate = j('#startDate').val();
                var endDate = j('#endDate').val();

                if (startDate != '' && endDate != '') {
                    table.columns(0).search(startDate + ':' + endDate).draw();
                } else {
                    table.columns(0).search('').draw();
                }
            });
        });
    });
    </script>

    <script>
    window.jsPDF = window.jspdf.jsPDF;

    function exportTableToExcel(tableId, filename) {
        var table = document.getElementById(tableId);
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });
        XLSX.writeFile(wb, filename);
    }

    function exportTableToPdf(tableId, filename) {
        var table = document.getElementById(tableId);
        var doc = new jsPDF();

        doc.setFontSize(10);

        var title = 'Repair request transactions';
        var titleWidth = doc.getStringUnitWidth(title) * doc.internal.getFontSize() / doc.internal.scaleFactor;
        var x = (doc.internal.pageSize.width - titleWidth) / 2;
        doc.setFontSize(16);
        doc.text(title, x, 20);
        doc.setFontSize(10);

        doc.autoTable({
            html: '#' + tableId,
            theme: 'striped',
            headStyles: {
                fillColor: [0, 0, 0], // Black
                textColor: [255, 255, 255] // White
            },
            startY: doc.pageCount > 1 ? doc.autoTableEndPosY() + 10 : 30
        });

        doc.save(filename);
    }


    document.getElementById('exportExcel').addEventListener('click', function() {
        exportTableToExcel('myDataTable', 'table_export.xlsx');
    });

    document.getElementById('exportPdf').addEventListener('click', function() {
        // Replace 'myDataTable' with the actual ID of the table you want to export
        exportTableToPdf('myDataTable', 'table_export.pdf');
    });

    document.getElementById('exportExcel2').addEventListener('click', function() {
        exportTableToExcel('myDataTable2', 'table_export2.xlsx');
    });

    document.getElementById('exportPdf2').addEventListener('click', function() {
        exportTableToPdf('myDataTable2', 'table_export2.pdf');
    });
    </script>

    <script>
    j(document).ready(function() {
        j('#myDataTable').DataTable();
    });

    j(document).ready(function() {
        j('#myDataTable2').DataTable();
    });
    </script>



</body>

</html>