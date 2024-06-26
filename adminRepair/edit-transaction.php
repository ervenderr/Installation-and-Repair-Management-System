<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];


$rpactive = "active";
$rpshow = "show";
$rptrue = "true";

    
// Perform the query to retrieve the data for the selected row
$query = "SELECT *
          FROM rprq
          JOIN customer ON rprq.cust_id = customer.cust_id
          JOIN accounts ON customer.account_id = accounts.account_id
          WHERE rprq.transaction_code = '" . $tcode . "';";
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
                                <i class="fas fa-tools menu-icon"></i>
                            </span> Repair Transaction <span class="bread">/ Update transaction</span>
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
                                        $query6 = "SELECT rprq.*, 
                                        customer.fname AS cust_fname, 
                                        customer.lname AS cust_lname, 
                                        technician.fname AS tech_fname, 
                                        technician.lname AS tech_lname, 
                                        technician.status AS tech_status, 
                                        rprq.status AS rprq_status, 
                                        accounts.*,
                                        technician.*,
                                        electronics.*,
                                        rp_warranty.*,
                                        defects.*,
                                        customer.*
                                      FROM rprq
                                      LEFT JOIN technician ON rprq.tech_id = technician.tech_id
                                      LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                                      LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
                                      LEFT JOIN rp_warranty ON rprq.id = rp_warranty.rpwarranty_id
                                      LEFT JOIN defects ON rprq.defect_id = defects.defect_id
                                      LEFT JOIN accounts ON customer.account_id = accounts.account_id
                                      WHERE rprq.transaction_code = '" . $tcode . "';";
                                        $result6 = mysqli_query($conn, $query6);
                                        
                                        // Check if the query was successful and output the data
                                        if (mysqli_num_rows($result6) > 0) {
                                            $row6 = mysqli_fetch_assoc($result6);
                                        }
                                        $selected_technician_id = $row6['tech_id'];
                                        $selected_elec_id = $row6['elec_id'];
                                        $selected_defect_id = $row6['defect_id'];
                                        $selected_warranty = $row6['warranty_status'];
                                        ?>
                                        <p class="card-description">Update Personal info </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="fname">First Name</label>
                                                    <div class="">
                                                        <input type="text" name="fname" class="form-control"
                                                            value="<?php echo $row6['cust_fname']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="lname">Last Name</label>
                                                    <div class="">
                                                        <input type="text" name="lname" class="form-control"
                                                            value="<?php echo $row6['cust_lname']; ?>" />
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
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="address" class="col-form-label">Address</label>
                                                    <div class="">
                                                        <input name="address" class="form-control" type="text"
                                                            value="<?php echo $row6['address']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="status" class="col-form-label">Status</label>
                                                    <div class="">
                                                        <select name="status" class="form-control">
                                                            <option value="Pending"
                                                                <?php if ($row6['rprq_status'] == 'Pending') echo 'selected'; ?>>
                                                                Pending
                                                            </option>
                                                            <option value="Accepted"
                                                                <?php if ($row6['rprq_status'] == 'Accepted') echo 'selected'; ?>>
                                                                Accepted
                                                            </option>
                                                            <option value="In-progress"
                                                                <?php if ($row6['rprq_status'] == 'In-progress') echo 'selected'; ?>>
                                                                In-progress
                                                            </option>
                                                            <option value="Done"
                                                                <?php if ($row6['rprq_status'] == 'Done') echo 'selected'; ?>>
                                                                Done
                                                            </option>
                                                            <option value="Completed"
                                                                <?php if ($row6['rprq_status'] == 'Completed') echo 'selected'; ?>>
                                                                Completed
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="etype" class="col-form-label">Electronic Type</label>
                                                    <div class="">
                                                        <select name="etype" class="form-control">
                                                            <option value="None">--- Select ---</option>
                                                            <?php
                                                                $sql2 = "SELECT * FROM electronics";
                                                                $result3 = mysqli_query($conn, $sql2);
                                                                while ($electronics = mysqli_fetch_assoc($result3)) {
                                                                    $elec_id = mysqli_real_escape_string($conn, $electronics['elec_id']);
                                                                    $selected = ($elec_id == $selected_elec_id) ? "selected" : "";
                                                                    echo "<option value='{$elec_id}' {$selected}>{$electronics['elec_name']}</option>";
                                                                }                                                        
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="technician" class="col-form-label">Assigned
                                                        Technician</label>
                                                    <div class="">
                                                        <select name="technician" class="form-control">
                                                            <option value="None">--- Select ---</option>
                                                            <?php
                                                                $sql2 = "SELECT * FROM technician";
                                                                $result3 = mysqli_query($conn, $sql2);
                                                                while ($technician = mysqli_fetch_assoc($result3)) {
                                                                    $tech_id = mysqli_real_escape_string($conn, $technician['tech_id']);
                                                                    $selected = ($tech_id == $selected_technician_id) ? "selected" : "";
                                                                    echo "<option value='{$tech_id}' {$selected}>{$technician['fname']} {$technician['lname']}</option>";
                                                                }                                                        
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                <label for="defective" class="col-form-label">Defective</label>
                                                        <div class="">
                                                            <select name="defective" id="defective" class="form-control">
                                                                <?php
                                                                $sql2 = "SELECT * FROM defects";
                                                                $result3 = mysqli_query($conn, $sql2);
                                                                while ($defects = mysqli_fetch_assoc($result3)) {
                                                                    $defect_id = mysqli_real_escape_string($conn, $defects['defect_id']);
                                                                    $selected = ($defect_id == $selected_defect_id) ? "selected" : "";
                                                                    echo "<option value='{$defect_id}' {$selected}>{$defects['defect_name']}</option>";
                                                                }
                                                                ?>
                                                                <option value="other">Other</option>
                                                            </select>
                                                            <span class="error-input"></span>
                                                        </div>
                                                    <div class="form-group" id="other-defect-input"
                                                        style="display:none;">
                                                        <label for="other_defective" class="col-form-label">Other
                                                            Defect</label>
                                                        <input type="text" name="other_defective" id="other_defective"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="shipping" class="col-form-label">Shipping option</label>
                                                    <div class="">
                                                        <select name="shipping" class="form-control">
                                                            <option value="None">--Select--</option>
                                                            <option value="Pickup"
                                                                <?php if ($row6['shipping'] == 'Pickup') echo 'selected'; ?>>
                                                                Pickup</option>
                                                            <option value="Deliver"
                                                                <?php if ($row6['shipping'] == 'Deliver') echo 'selected'; ?>>
                                                                Deliver
                                                            </option>
                                                            <option value="Home Service"
                                                                <?php if ($row['shipping'] == 'Home Service') echo 'selected'; ?>>
                                                                Home
                                                                Service</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="date" class="col-form-label">Date</label>
                                                    <div class="">
                                                        <input name="date" type="date" class="form-control"
                                                            placeholder="dd/mm/yyyy"
                                                            value="<?php echo $row6['date_req']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="completed" class="col-form-label">Date Completed</label>
                                                    <div class="">
                                                        <input name="completed" type="date" class="form-control"
                                                            placeholder="dd/mm/yyyy"
                                                            value="<?php echo $row6['date_completed']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="initial_payment" class="col-form-label">Initial
                                                        Payment</label>
                                                    <div class="">
                                                        <input name="initial_payment" class="form-control" type="text"
                                                            value="<?php echo $row6['initial_payment']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="payment" class="col-form-label">Full Payment</label>
                                                    <div class="">
                                                        <input name="payment" class="form-control" type="text"
                                                            value="<?php echo $row6['payment']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="remarks" class="col-form-label">Remarks</label>
                                                    <div class="">
                                                        <textarea name="remarks" class="form-control"
                                                            rows="3"><?php echo $row['remarks']?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="backlog" class="col-form-label">Backlog</label>
                                                    <div class="">
                                                    <select name="backlog" class="form-control">
                                                            <option value="None">--Select--</option>
                                                            <option value="1"
                                                                <?php if ($row6['backlog'] == 1) echo 'selected'; ?>>
                                                                Yes</option>
                                                            <option value="0"
                                                                <?php if ($row6['backlog'] == 0) echo 'selected'; ?>>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="warranty" class="col-form-label">Warranty Status</label>
                                                    <div class="">
                                                    <select name="warranty" class="form-control">
                                                            <option value="Under warranty"
                                                                <?php if ($row6['warranty_status'] == 'Under warranty') echo 'selected'; ?>>
                                                                Under warranty
                                                            </option>
                                                            <option value="Warranty claimed"
                                                                <?php if ($row6['warranty_status'] == 'Warranty claimed') echo 'selected'; ?>>
                                                                Warranty claimed
                                                            </option>
                                                            <option value="Warranty expired"
                                                                <?php if ($row6['warranty_status'] == 'Warranty expired') echo 'selected'; ?>>
                                                                Warranty expired
                                                            </option>
                                                            
                                                        </select>
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

<script>
    document.getElementById('defective').addEventListener('change', function() {
        if (this.value === 'other') {
            document.getElementById('other-defect-input').style.display = 'block';
        } else {
            document.getElementById('other-defect-input').style.display = 'none';
        }
    });
</script>
</body>

</html>