<?php
require_once '../admin_includes/header.php';
require_once '../homeincludes/dbconfig.php';
require_once '../tools/variables.php';

$rpactive = "active";
$rpshow = "show";
$rptrue = "true";

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT rprq.id, rprq.transaction_code, rprq.status, customer.fname, customer.lname, customer.address, customer.phone, accounts.email, rprq.etype, rprq.defective, rprq.date_req, rprq.date_completed, rprq.shipping
          FROM rprq
          JOIN customer ON rprq.cust_id = customer.cust_id
          JOIN accounts ON customer.account_id = accounts.account_id
          WHERE rprq.transaction_code = '" . $tcode . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php require_once '../admin_includes/navbar.php'; ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php require_once '../admin_includes/sidebar.php'; ?>
            
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                                <i class="mdi mdi-wrench"></i>
                            </span> Repair Transaction
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <?php
                                $href = "";
                                if ($row['status'] == 'Pending'){
                                    $href = "pending.php";
                                }else{
                                    $href = "transaction.php";
                                }
                                ?>
                                <a href="<?php echo $href; ?>">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span><i class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                    </i>
                                </li></a>
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
                                                <td><?php echo $row['fname'] ." " .  $row['lname']?></td>
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
                                                <th>Electronic Type:</th>
                                                <td><?php echo $row['etype']?></td>
                                            </tr>
                                            <tr>
                                                <th>Defective:</th>
                                                <td><?php echo $row['defective']?></td>
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
                                                <th>Assigned Technician:</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Option:</th>
                                                <td><?php echo $row['shipping']?></td>
                                            </tr>
                                            <tr>
                                                <th>Warranty:</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Payment:</th>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <div class="btn-group-sm d-flex btn-details">
                                        <?php
                                            echo '<a href="edit-transaction.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['id'] . '" class="btn btn-success btn-fw">Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            echo '<a href="delete-transaction.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['id'] . '" class="btn btn-danger btn-fw red">Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';
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