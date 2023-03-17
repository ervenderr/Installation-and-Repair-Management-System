<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$seractive = "active";
$sershow = "show";
$sertrue = "true";

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT sr.*, 
       c.fname AS cust_fname, 
       c.lname AS cust_lname, 
       GROUP_CONCAT(CONCAT(t.fname, ' ', t.lname)) AS tech_names,
       a.*,
       c.*,
       s.*,
       invoice.*,
       p.*
FROM service_request sr
LEFT JOIN customer c ON sr.cust_id = c.cust_id
LEFT JOIN accounts a ON c.account_id = a.account_id
LEFT JOIN services s ON sr.service_id = s.service_id
LEFT JOIN package p ON sr.pkg_id = p.pkg_id
LEFT JOIN service_request_technicians srt ON sr.sreq_id = srt.sreq_id
LEFT JOIN technician t ON srt.tech_id = t.tech_id
LEFT JOIN invoice ON sr.invoice_id = invoice.invoice_id
WHERE sr.transaction_code = '" . $tcode . "'
GROUP BY sr.sreq_id;";


$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

$_SESSION['account_id'] = $row['account_id'];
$_SESSION['rowid'] = $_GET['rowid'];
$_SESSION['transaction_code'] = $_GET['transaction_code'];
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
                                <i class="fas fa-cogs menu-icon"></i>
                            </span> Service Transaction
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <?php
                                $href = "";
                                if ($row['status'] == 'Pending'){
                                    $href = "pendings.php";
                                }else{
                                    $href = "transactions.php";
                                }
                                ?>
                                <a href="<?php echo $href; ?>">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span></span><i
                                            class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                        </i>
                                    </li>
                                </a>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Transaction Code:</th>
                                                <td><?php echo $row['transaction_code']?></td>
                                            </tr>
                                            <tr>
                                                <th>Invoice Number:</th>
                                                <td><?php echo $row['invoice_no']?></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                $statusClass = '';
                                                if ($row['status'] == 'Pending') {
                                                  $statusClass = 'badge-gradient-warning';
                                                } else if ($row['status'] == 'In-progress') {
                                                  $statusClass = 'badge-gradient-info';
                                                } else if ($row['status'] == 'Done') {
                                                  $statusClass = 'badge-gradient-success';
                                                } else {
                                                  $statusClass = 'badge-gradient-secondary';
                                                }      
                                                echo "<th>Status:</th>";
                                                echo "<td><span class='badge " . $statusClass . "'>" . $row['status'] . "</span></td>";
                                                ?>
                                            </tr>
                                            <tr>
                                                <th>Customer Name:</th>
                                                <td><?php echo $row['cust_fname'] ." ".  $row['cust_lname']?></td>
                                            </tr>
                                            <tr>
                                                <th>Address:</th>
                                                <td><?php echo $row['address']?></td>
                                            </tr>
                                            <tr>
                                                <th>Contact:</th>
                                                <td><?php echo $row['phone']?></td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td><?php echo $row['email']?></td>
                                            </tr>
                                            <tr>
                                                <th>Service Type:</th>
                                                <td><?php echo $row['service_name']?></td>
                                            </tr>
                                            <tr>
                                                <th>Package:</th>
                                                <td><?php echo $row['name']?></td>
                                            </tr>
                                            <tr>
                                                <th>Other concern:</th>
                                                <td><?php echo $row['other']?></td>
                                            </tr>
                                            <tr>
                                                <th>Date Requested:</th>
                                                <td><?php echo $row['date_req']?></td>
                                            </tr>
                                            <tr>
                                                <th>Date Completed:</th>
                                                <td><?php echo $row['date_completed']?></td>
                                            </tr>
                                            <tr>
                                                <th>Assigned Technicians:</th>
                                                <td><?php echo $row['tech_names']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Warranty:</th>
                                                <td>3 Months</td>
                                            </tr>
                                            <tr>
                                                <th>Initial Payment:</th>
                                                <td><?php echo $row['initial_payment']?></td>
                                            </tr>
                                            <tr>
                                                <th>Full Payment:</th>
                                                <td><?php echo $row['payment']?></td>
                                            </tr>
                                        </table>
                                        <div class="btn-group-sm d-flex btn-details">
                                            <?php
                                            if (($row['status'] == 'Pending')) {
                                                echo '<button class="icns btn btn-danger edit" id="' .  $row['sreq_id'] . '">';
                                                echo 'Accept <i class="fas fa-check-square view-account" id="' .  $row['sreq_id'] . '"></i>';
                                                echo '</button>';
                                            }
                                            else{
                                                echo '<a href="edit-transactions.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['sreq_id'] . '" class="btn btn-success btn-fw">
                                            Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            }

                                            echo '<a href="delete-transactions.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['sreq_id'] . '" class="btn btn-danger btn-fw red">
                                            Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';

                                            if (empty($row['invoice_id']) && $row['status'] == 'Done') {
                                                echo '<a href="../service-invoice/serv_invoice_form.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['sreq_id'] . '" class="btn btn-primary btn-fw">
                                                Generate Invoice <i class="fas fa-file-invoice"></i></a>';
                                            }

                                            if (!empty($row['invoice_id'])) {
                                                $invoice_id = $row['invoice_id'];
                                                echo '<a href="../service-invoice/print.php?invoice_id=' . $invoice_id .'" target="_blank" class="btn btn-secondary btn-fw ">
                                                Download Invoice <i class="fas fa-download"></i></a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
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
</body>

</html>