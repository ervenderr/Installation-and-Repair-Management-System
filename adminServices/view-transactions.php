<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$seractive = "active";
$sershow = "show";
$sertrue = "true";

$rowid = $_GET['rowid'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT service_request.*, 
technician.fname AS tech_fname, 
technician.lname AS tech_lname, 
technician.phone AS tech_phone,
technician.status AS tech_status, 
customer.fname AS cust_fname, 
customer.lname AS cust_lname, 
customer.phone AS cust_phone,
service_request.status AS sr_status, 
GROUP_CONCAT(CONCAT(technician.fname, ' ', technician.lname)) AS tech_names,
accounts.*,
technician.*,
services.*,
package.*,
customer.*
FROM service_request
LEFT JOIN service_request_technicians ON service_request.sreq_id = service_request_technicians.sreq_id
LEFT JOIN technician ON service_request_technicians.tech_id = technician.tech_id
LEFT JOIN services ON service_request.service_id = services.service_id
LEFT JOIN package ON service_request.pkg_id = package.pkg_id
LEFT JOIN customer ON service_request.cust_id = customer.cust_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
WHERE service_request.sreq_id = '" . $rowid . "'
GROUP BY service_request.sreq_id;";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

$_SESSION['account_id'] = $row['account_id'];
$_SESSION['rowid'] = $_GET['rowid'];
?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once ('../admin_includes/navbar.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once ('../admin_includes/sidebar.php'); ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                                <i class="mdi mdi-wrench"></i>
                            </span> Repair Transaction

                        </h3>
                        <?php
            if (isset($_SESSION['msg'])) {
                $msg = $_SESSION['msg'];
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                '. $msg .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              unset ($_SESSION['msg']);
            }

            if (isset($_SESSION['msg2'])) {
                $msg2 = $_SESSION['msg2'];
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                '. $msg2 .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            unset ($_SESSION['msg']);
        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <?php
                                $href = "";
                                if ($row['sr_status'] == 'Pending'){
                                    $href = "pending.php";
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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title h-card">Customer Details</h4>
                                    <div>
                                        <a href="edit-transaction.php?transaction_code=<?php echo $row['transaction_code']; ?>&rowid=<?php echo $row['sreq_id']; ?>"
                                            class="btn btn-success btn-fw btn-edit">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
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
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title h-card">Request Details</h4>
                                    <div>
                                        <a href="edit-transaction.php?transaction_code=<?php echo $row['transaction_code']; ?>&rowid=<?php echo $row['sreq_id']; ?>"
                                            class="btn btn-success btn-fw btn-edit">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
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
                                                <td><?php echo $row['invoice_id']?></td>
                                            </tr>
                                            <?php
                        $statusClass = '';
                        if ($row['sr_status'] == 'Pending') {
                            $statusClass = 'badge-gradient-warning';
                        } else if ($row['sr_status'] == 'In-progress' || $row['sr_status'] == 'To repair') {
                            $statusClass = 'badge-gradient-info';
                        } else if ($row['sr_status'] == 'Cancelled') {
                            $statusClass = 'badge-gradient-secondary';
                        } else {
                            $statusClass = 'badge-gradient-success';
                        }
                        echo "<tr>";
                        echo "<th>Status:</th>";
                        echo "<td><span class='badge " . $statusClass . "'>" . $row['sr_status'] . "</span></td>";
                        echo "</tr>";
                    ?>
                                            <?php
                        $backlog = '';
                        if ($row['backlogs'] == '1') {
                            $backlog = 'Yes';
                        } else {
                            $backlog = 'No';
                        }
                    ?>
                                            <tr>
                                                <th>Backlog:</th>
                                                <td><span class="not-back"><?php echo $backlog; ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>Service Type:</th>
                                                <td><?php echo $row['service_name']?></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>Package:</th>
                                                <td>
                                                    <?php echo $row['name']?>
                                                </td>
                                            </tr>
                                            </tr>
                                            <tr>
                                                <th>Date Requested:</th>
                                                <td><?php echo $row['date_req']?></td>
                                            </tr>
                                            <tr>
                                                <th>Date Completed:</th>
                                                <td><?php
                                                if($row['sr_status'] == 'Completed'){
                                                echo $row['date_completed'];}?></td>
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
                                                <td><?php echo number_format($row['initial_payment'] ,2)?></td>
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
                                    <table class="table table-bordered table-trans" id="myDataTable">
                                        <thead>
                                            <tr class="bg-our spaces">
                                                <th> Package Name </th>
                                                <th> COST </th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            <?php
                                            $id = $row['sreq_id'];

                                            $lresult = mysqli_query($conn, $query);

                                            // Initialize the labor subtotal
                                            $labor_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $labor_subtotal += $lrow['price'];
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['name'] . '</td>';
                                                echo '<td>' . number_format($lrow['price'] ,2) . '</td>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the labor subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td class="text-end labortotal"> Labor Subtotal:  </td>';
                                            echo '<td class="Sub Total labortotal">' . $labor_subtotal .".00". '</td>';
                                            echo '</tr>';



                                            echo '<tr class="spaces">';
                                            echo '<td colspan="4" class="text-end"> </td>';
                                            
                                            if(!empty($row['discount'])){
                                                echo '<tr>';
                                                echo '<td class="text-end "> Discount:  </td>';
                                                echo '<td class="">'. number_format($row['discount'] ,2) .'</td>';
                                                echo '</tr>';
                                            }


                                            
                                            $grand_total = $labor_subtotal-$row['discount'];
                                            
                                            
                                        ?>
                                        </tbody>
                                    </table>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex align-items-center grandtotal">
                                <h3>Total Payable Amount: <?php echo number_format($grand_total, 2) ?></h3>
                                <?php if($row['sr_status'] == 'Completed'){
                            echo '<span class="grandspan">Paid <i class="far fa-money-check-edit-alt"></i></span>';
                        } ?>
                            </div>
                        </div>
                        <div class="d-flex btn-details">
                            <?php
                                            if (empty($row['invoice_id']) && $row['sr_status'] == 'Done') {
                                                echo '<a href="../repair-invoice/rp_invoice_form.php?transaction_code=' . $row['transaction_code'] . '&rowid=' .  $row['sreq_id'] . '" class="btn btn-primary btn-fw">
                                                Generate Invoice <i class="fas fa-file-invoice"></i></a>';
                                            }

                                            if (!empty($row['invoice_id'])) {
                                                $invoice_id = $row['invoice_id'];
                                                echo '<a href="../repair-invoice/print.php?invoice_id=' . $invoice_id .'" target="_blank" class="btn btn-secondary btn-fw ">
                                                Download Invoice <i class="fas fa-download"></i></a>';
                                            }

                                            if ($row['sr_status'] == 'Pending') {
                                                $_SESSION['transaction_code'] = $row['transaction_code'];
                                                echo '<button class="icns btn btn-danger edit acceptrp" id="' .  $row['sreq_id'] . '">';
                                                echo '<i class="fas fa-calendar-check view-account" id="' .  $row['sreq_id'] . '"> </i> Accept';
                                                echo '</button>';
                                            }

                                            if (($row['sreq_id'])) {
                                                $_SESSION['transaction_code'] = $row['transaction_code'];
                                                echo '<button class="icns btn btn-danger update_status" id="' .  $row['sreq_id'] . '">';
                                                echo '<i class="fas fa-edit"></i> Update Status';
                                                echo '</button>';
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
    <!-- Accept modal -->
    <div class="modal fade" id="editSuppModal" tabindex="-1" aria-labelledby="editSuppModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuppModalLabel">Assign Technician</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body suppbody">

                </div>
            </div>
        </div>
    </div>



    <!-- initial payment modal -->
    <div class="modal fade " id="initpay" tabindex="-1" aria-labelledby="initpayLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="initpayLabel">Update Initial Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body initpays">

                </div>
            </div>
        </div>
    </div>

    <!-- update status modal -->
    <div class="modal fade " id="update_status" tabindex="-1" aria-labelledby="update_statusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_statusLabel">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body update_statuses">

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
                url: 'accept-pending.php',
                method: 'post',
                data: {
                    sreq_id: id
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

    <script>
    $(document).ready(function() {

        $('.initpay').click(function() {

            id = $(this).attr('id');
            $.ajax({
                url: 'accepted-pending.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.initpays').html(result);
                }
            });


            $('#initpay').modal('show');
        })

        $('.update_status').click(function() {

            id = $(this).attr('id');
            $.ajax({
                url: 'update-status.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.update_statuses').html(result);
                }
            });


            $('#update_status').modal('show');
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