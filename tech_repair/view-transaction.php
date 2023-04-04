<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$rpactive = "active";
$rpshow = "show";
$rptrue = "true";

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'technician'){
    header('location: ../login/login.php');
}
// Perform the query to retrieve the data for the selected row
$query = "SELECT rprq.*, 
customer.fname AS cust_fname, 
customer.lname AS cust_lname, 
technician.fname AS tech_fname, 
technician.lname AS tech_lname, 
technician.status AS tech_status_new_name, 
rprq.status AS rprq_status, 
accounts.*,
technician.*,
electronics.*,
defects.*,
invoice.*,
customer.*
FROM rprq
LEFT JOIN technician ON rprq.tech_id = technician.tech_id
LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
LEFT JOIN defects ON rprq.defect_id = defects.defect_id
LEFT JOIN customer ON rprq.cust_id = customer.cust_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
LEFT JOIN invoice ON rprq.id = invoice.rprq_id
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
        <?php include_once ('../technician_includes/navbar.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once ('../technician_includes/sidebar.php'); ?>

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
                                if ($row['rprq_status'] == 'Pending'){
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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between"">
                                    <h4 class=" card-title h-card">Customer Details</h4>
                                    <div>
                                        <button class="btn btn-success btn-fw btn-edit minimize"><i
                                                class="fas fa-minus text-white"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Customer Name:</th>
                                                <td><?php echo $row['cust_fname'] ." " .  $row['cust_lname']?></td>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between"">
                                    <h4 class=" card-title h-card">Request Details</h4>
                                    <div>
                                        <button class="btn btn-success btn-fw btn-edit minimize"><i
                                                class="fas fa-minus text-white"></i></button>
                                    </div>
                                </div>
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
                                            <?php
                        $statusClass = '';
                        if ($row['rprq_status'] == 'Pending') {
                            $statusClass = 'badge-gradient-warning';
                        } else if ($row['rprq_status'] == 'In-progress') {
                            $statusClass = 'badge-gradient-info';
                        } else if ($row['rprq_status'] == 'Done') {
                            $statusClass = 'badge-gradient-success';
                        } else if ($row['rprq_status'] == 'Completed') {
                            $statusClass = 'badge-gradient-success';
                        } else {
                            $statusClass = 'badge-gradient-secondary';
                        }
                        echo "<tr>";
                        echo "<th>Status:</th>";
                        echo "<td><span class='badge " . $statusClass . "'>" . $row['rprq_status'] . "</span></td>";
                        echo "</tr>";
                    ?>
                                            <?php
                        $backlog = '';
                        if ($row['backlog'] == '1') {
                            $backlog = 'backlog-red';
                        } else {
                            $backlog = 'badge-gradient-success';
                        }
                    ?>
                                            <tr>
                                                <th>Backlog:</th>
                                                <td><span class="badge <?php echo $backlog; ?> not-back"> </span></td>
                                            </tr>
                                            <tr>
                                                <th>Electronic Type:</th>
                                                <td><?php echo $row['elec_name']?></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>Defective:</th>
                                                <td>
                                                    <?php
                                                        if (empty($row['defect_id']) || $row['defect_id'] == 0) {
                                                            echo $row['other_defects'];
                                                        } else {
                                                            echo $row['defect_name'];
                                                        }
                                                        ?>
                                                </td>
                                            </tr>
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
                                                <td><?php echo $row['tech_fname'] . " " . $row['tech_lname']?></td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Option:</th>
                                                <td><?php echo $row['shipping']?></td>
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
                                            <tr>
                                                <th>Remarks:</th>
                                                <td>
                                                    <textarea class="form-control" rows="3"
                                                        readonly><?php echo $row['remarks']?></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <h4 class="card-title mt-3">Labor Cost</h4>
                            <div class="col-12 grid-margin">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="myDataTable">
                                        <thead>
                                            <tr class="bg-our">
                                                <th> LABOR </th>
                                                <th> COST </th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            <?php
                                            $id = $row['id'];
                                            $lquery = "SELECT *
                                                FROM rprq
                                                INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                INNER JOIN rp_labor ON rprq.id = rp_labor.rprq_rl_id
                                                INNER JOIN common_repairs ON rp_labor.comrep_id = common_repairs.comrep_id
                                                WHERE rprq.id = $id";

                                            $lresult = mysqli_query($conn, $lquery);

                                            // Initialize the labor subtotal
                                            $labor_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $labor_subtotal += $lrow['comrep_cost'];
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['comrep_name'] . '</td>';
                                                echo '<td>' . $lrow['comrep_cost'] . '</td>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the labor subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td class="text-end labortotal"> Labor Subtotal:  </td>';
                                            echo '<td class="labortotal">' . $labor_subtotal .".00". '</td>';
                                            echo '</tr>';
                                            
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h4 class="card-title mt-2">Parts Cost</h4>
                            <div class="col-12 grid-margin">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="myDataTable">
                                        <thead>
                                            <tr class="bg-our">
                                                <th> Part name </th>
                                                <th> price </th>
                                                <th> qty </th>
                                                <th> total </th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            <?php
                                            $id = $row['id'];
                                            $lquery = "SELECT *
                                                FROM rprq
                                                INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                INNER JOIN rp_brand_parts ON rprq.id = rp_brand_parts.rprq_id
                                                INNER JOIN brand_parts ON rp_brand_parts.bp_id = brand_parts.bp_id
                                                WHERE rprq.id = $id";

                                            $lresult = mysqli_query($conn, $lquery);

                                            // Initialize the labor subtotal
                                            $partqty = 0;
                                            $part_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $partqty  = $lrow['bp_cost'] * $lrow['quantity'];
                                                $part_subtotal += $partqty;
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['bp_name'] . '</td>';
                                                echo '<td>' . $lrow['bp_cost'] . '</td>';
                                                echo '<td>' . $lrow['quantity'] . '</td>';
                                                echo '<td>' . $partqty . '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the parts subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-end labortotal"> Parts Subtotal:  </td>';
                                            echo '<td class="labortotal">' . $part_subtotal .".00". '</td>';
                                            echo '</tr>';

                                            $grand_total = $part_subtotal+$labor_subtotal;


                                            
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h3>Total Payable Amount: <?php echo $grand_total.".00" ?></h3>
                        </div>
                        <div class="d-flex btn-details">
                            <?php
                                            if($row['rprq_status'] != 'Completed' && $row['rprq_status'] == 'Diagnosing'){
                                                $_SESSION['transaction_code'] = $row['transaction_code'];
                                                echo '<button class="icns btn btn-success edit updtech" id="' .  $row['id'] . '">';
                                                echo 'Update Diagnosing <i class="fas fa-check-square view-account" id="' .  $row['id'] . '"></i>';
                                                echo '</button>';
                                            }


                                            if (empty($row['invoice_id']) && $row['rprq_status'] == 'Done') {
                                                echo '<a href="../repair-invoice/rp_invoice_form.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['id'] . '" class="btn btn-primary btn-fw">
                                                Generate Invoice <i class="fas fa-file-invoice"></i></a>';
                                            }

                                            if (!empty($row['invoice_id'])) {
                                                $invoice_id = $row['invoice_id'];
                                                echo '<a href="../repair-invoice/print.php?invoice_id=' . $invoice_id .'" target="_blank" class="btn btn-secondary btn-fw ">
                                                Download Invoice <i class="fas fa-download"></i></a>';
                                            }

                                            
                                            ?>
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

    <!-- Accept modal -->
    <div class="modal fade " id="editSuppModal" tabindex="-1" aria-labelledby="editSuppModalLabel" aria-hidden="true">
        <div class="modal-dialog diangmod">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuppModalLabel">Repair Request Diagnosing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body suppbody">

                </div>
            </div>
        </div>
    </div>



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
    $(document).ready(function() {
        $('.edit').click(function() {

            id = $(this).attr('id');
            $.ajax({
                url: 'update-status.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.suppbody').html(result);
                }
            });


            $('#editSuppModal').modal('show');
        })

        
    })
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({});
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const minimizeButtons = document.querySelectorAll(".minimize");

        minimizeButtons.forEach(function(minimizeButton) {
            minimizeButton.addEventListener("click", function() {
                const cardBody = minimizeButton.closest(".card").querySelector(".card-body");
                cardBody.classList.toggle("d-none");

                if (cardBody.classList.contains("d-none")) {
                    minimizeButton.innerHTML = '<i class="fas fa-chevron-down text-white"></i>';
                } else {
                    minimizeButton.innerHTML = '<i class="fas fa-minus text-white"></i>';
                }
            });
        });
    });
    </script>
</body>

</html>