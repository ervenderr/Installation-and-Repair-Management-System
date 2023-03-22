<?php
session_start();

include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');
$reports = 'active';

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
                                <a class="nav-link" aria-current="page" href="reports.php">Repair Sales
                                    Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="services-reports.php">Services Sales Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="backlogs.php">Backlogs / Cancelled</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="product-reports.php">Products</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card report-card-two text-center rp-card">
                        <div class="card-body">
                            <h4 class="card-title">Products Record</h4>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <div class="btn-group text-center" role="group">
                                            <button type="button" class="xpt" id="exportExcel2">Export to
                                                Excel</button>
                                            <button type="button" class="xpt" id="exportPdf2">Export to
                                                PDF</button>
                                        </div>

                                        <table class="table table-hover" id="myDataTable2">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> SKU </th>
                                                    <th> Product Name </th>
                                                    <th> Category </th>
                                                    <th> Cost </th>
                                                    <th> Price </th>
                                                    <th> Stock-in </th>
                                                    <th> Stock-out </th>
                                                    <th> Total stock </th>
                                                    <th> ACTION </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable2">
                                                <?php
                                            $sql_all = "SELECT products.*, 
                                            SUM(inventory.stock_in) as stock_in,
                                            SUM(inventory.stockout) as stockout,
                                            SUM(inventory.stock_in) - SUM(inventory.stockout) as total_stocks,
                                            COALESCE(inventory.cost, '') AS cost,
                                            category.categ_name
                                            FROM products
                                            LEFT JOIN inventory ON products.product_id = inventory.product_id
                                            INNER JOIN category ON products.categ_id = category.categ_id
                                            GROUP BY products.product_id;";
                                            
                                            $result_all = $conn->query($sql_all);
                                            if ($result_all->num_rows > 0) {
                                                $count = 1;
                                                while ($row = $result_all->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["sku"] . "</td>"; 
                                                    echo "<td>" . $row["name"] . "</td>"; 
                                                    echo "<td>" . $row["categ_name"] . "</td>"; 
                                                    echo "<td>" . $row["cost"] . "</td>"; 
                                                    echo "<td>" . $row["price"] . "</td>"; 
                                                    echo "<td>" . $row["stock_in"] . "</td>";
                                                    echo "<td>" . $row["stockout"] . "</td>";
                                                    echo "<td>" . $row["total_stocks"] . "</td>";
                                                    echo '<td>';
                                                    echo '<a class="icns" href="../inventory/view-inventory.php?prod_id=' .  $row['product_id'] . '">';
                                                            echo '<i class="fas fa-eye text-white view-accoun view" Prod_id="' .  $row['product_id'] . '"></i>';
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

        // Required for jsPDF to work with autoTable correctly
        doc.setFontSize(10);

        // Add a header title
        var title = 'Service Request Transactions';
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
        // Replace 'myDataTable' with the actual ID of the table you want to export
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