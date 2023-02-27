<?php
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');





$rowid = $_GET['rowid'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT customer.cust_id, customer.fname, customer.lname, customer.phone, customer.address, customer.cust_type, accounts.email, accounts.user_type
            FROM customer
            JOIN accounts ON customer.account_id = accounts.account_id
            WHERE customer.cust_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

$custactive = "active";
$custshow = "show";


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
            <?php
            $type = "";
            $href = "";
            if ($row['cust_type'] == 'walk-in'){
                $href = "walk-in.php";
                $type = "/ Walk-in customer";

            }elseif($row['cust_type'] == 'online'){
                $href = "online.php";
                $type = "/ Online customer";
            }
            ?>
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                            <i class="fas fa-users menu-icon"></i>
                            </span> Customer<span class="bread"><?php echo $type; ?></span>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                
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
                                                <th class="bg-gryy">Customer Name:</th>
                                                <td><?php echo $row['fname'] ." " .  $row['lname']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Address:</th>
                                                <td><?php echo $row['address']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Contact:</th>
                                                <td><?php echo $row['phone']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Email:</th>
                                                <td><?php echo $row['email']?></td>
                                            </tr><tr>
                                                <th class="bg-gryy">Customer type:</th>
                                                <td><?php echo $row['cust_type']?></td>
                                            </tr>
                                        </table>
                                        <div class="btn-group-sm d-flex btn-details">
                                        <?php
                                            echo '<a href="edit-customer.php?&rowid=' .  $row['cust_id'] . '" class="btn btn-success btn-fw">Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            echo '<a href="delete-customer.php?&rowid=' .  $row['cust_id'] . '" class="btn btn-danger btn-fw red">Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';
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
