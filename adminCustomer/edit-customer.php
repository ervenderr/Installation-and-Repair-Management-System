<?php
include_once('../admin_includes/header.php');
include_once('../homeincludes/dbconfig.php');


$custactive = "active";
$custshow = "show";


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
                                <i class="mdi mdi-wrench"></i>
                            </span> Repair Transaction <span class="bread">/ Update customer info</span>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                            <?php
                                $href = "";
                                if ($row['cust_type'] == 'walk-in'){
                                    $href = "walk-in.php";

                                }elseif($row['cust_type'] == 'online'){
                                    $href = "online.php";
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
                                    <form class="form-sample" action="edit-process.php" method="POST"
                                        enctype="multipart/form-data">
                                        <?php
                                        $query6 = "SELECT customer.cust_id, customer.fname, customer.lname, customer.phone, customer.address, customer.cust_type, accounts.email, accounts.user_type
                                        FROM customer
                                        JOIN accounts ON customer.account_id = accounts.account_id
                                        WHERE customer.cust_id = '" . $rowid . "';";
                                        $result6 = mysqli_query($conn, $query6);
                                        
                                        // Check if the query was successful and output the data
                                        if (mysqli_num_rows($result6) > 0) {
                                            $row6 = mysqli_fetch_assoc($result6);
                                        }
                                        ?>
                                        <p class="card-description">Update Personal info </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="fname">First Name</label>
                                                    <div class="">
                                                        <input type="text" name="fname" class="form-control"
                                                            value="<?php echo $row6['fname']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="lname">Last Name</label>
                                                    <div class="">
                                                        <input type="text" name="lname" class="form-control"
                                                            value="<?php echo $row6['lname']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="email" class="col-form-label">Email</label>
                                                    <div class="">
                                                        <input name="email" class="form-control" type="email"
                                                            value="<?php echo $row6['email']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="phone" class="col-form-label">Phone</label>
                                                    <div class="">
                                                        <input name="phone" class="form-control" type="tel"
                                                            value="<?php echo $row6['phone']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="address" class="col-form-label">Address</label>
                                                    <div class="">
                                                        <input name="address" class="form-control" type="text"
                                                            value="<?php echo $row6['address']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input name="submit" type="submit" class="btn btn-info"
                                                value="Update Transaction" />
                                        </div>
                                    </form>
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