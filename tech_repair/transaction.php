<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'technician'){
    header('location: ../login/login.php');
}
$user_id = $_SESSION['logged_id'];

$techquery = "SELECT * FROM technician WHERE account_id = $user_id";

$techresult = mysqli_query($conn, $techquery);
if (mysqli_num_rows($techresult) > 0) {
    $techrow = mysqli_fetch_assoc($techresult);
}

include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';

?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once('../technician_includes/navbar.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once('../technician_includes/sidebar.php'); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                                <i class="fas fa-tools menu-icon"></i>
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

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex">
                                    <h4 class="card-title">List of My Transaction</h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="myDataTable">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Transaction Code </th>
                                                    <th> Customer </th>
                                                    <th> Status </th>
                                                    <th> Date </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                $user_id = $techrow['tech_id'];
                                                    // Perform the query
                                                    $query = "SELECT *
                                                        FROM rprq
                                                        INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                        WHERE rprq.status != 'Pending' AND rprq.tech_id = $user_id
                                                        ORDER BY rprq.date_req DESC";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $modalId = 'editTransactionModal-' . $id;
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['transaction_code'] . '</td>';
                                                        echo '<td>' . $row['fname'] . '  ' . $row['lname'] . '</td>';
                                                    
                                                        $statusClass = '';
                                                        if ($row['status'] == 'Pending') {
                                                            $statusClass = 'badge-gradient-warning';
                                                        } else if ($row['status'] == 'In-progress') {
                                                            $statusClass = 'badge-gradient-info';
                                                        } else if ($row['status'] == 'Cancelled') {
                                                            $statusClass = 'badge-gradient-secondary';
                                                        } else {
                                                            $statusClass = 'badge-gradient-success';
                                                        }
                                                    
                                                        echo '<td><label class="badge ' . $statusClass . '">' . $row['status'] . '</label></td>';
                                                        echo '<td>' . $row['date_req'] . '</td>';
                                                        echo '<td class="btn-group-sm">';
                                                        echo '<a class="icns btn btn-info" href="view-transaction.php?transaction_code=' . $row['transaction_code'] . '&rowid=' . $row['id'] . '">';
                                                        echo '<i class="fas fa-eye view-account" Prod_id="' .  $row['id'] . '"></i> View';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;
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

                <?php include_once('../modals/add-repair-modal.php') ?>
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
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>
    
    

    <script>
    const form = document.querySelector('.form-sample');
    const fname = form.querySelector('input[name="fname"]');
    const lname = form.querySelector('input[name="lname"]');
    // const email = form.querySelector('input[name="email"]');
    const phone = form.querySelector('input[name="phone"]');
    const address = form.querySelector('input[name="address"]');
    const etype = form.querySelector('select[name="etype"]');
    // const electrician = form.querySelector('select[name="electrician"]');
    const defective = form.querySelector('input[name="defective"]');
    const shipping = form.querySelector('select[name="shipping"]');
    const date = form.querySelector('input[name="date"]');
    const completed = form.querySelector('input[name="completed"]');
    const payment = form.querySelector('input[name="payment"]');

    form.addEventListener('submit', (event) => {
        let error = false;

        if (fname.value === '') {
            fname.nextElementSibling.innerText = 'Please enter first name';
            error = true;
        } else if (!/^[A-Z][a-z]*$/.test(fname.value)) {
            fname.nextElementSibling.innerText = 'First name should be capitalized';
            error = true;
        } else {
            fname.nextElementSibling.innerText = '';
        }

        if (lname.value === '') {
            lname.nextElementSibling.innerText = 'Please enter last name';
            error = true;
        } else if (!/^[A-Z][a-z]*$/.test(lname.value)) {
            lname.nextElementSibling.innerText = 'Last name should be capitalized';
            error = true;
        } else {
            lname.nextElementSibling.innerText = '';
        }

        // if (email.value === '') {
        //     email.nextElementSibling.innerText = 'Please enter your email';
        //     error = true;
        // } else {
        //     email.nextElementSibling.innerText = '';
        // }

        if (phone.value === '') {
            phone.nextElementSibling.innerText = 'Please enter phone number';
            error = true;
        } else if (!/^\d{11}$/.test(phone.value)) {
            phone.nextElementSibling.innerText = 'Please enter a valid 11-digit phone number';
            error = true;
        } else {
            phone.nextElementSibling.innerText = '';
        }

        if (address.value === '') {
            address.nextElementSibling.innerText = 'Please enter address';
            error = true;
        } else if (!/^[a-zA-Z0-9\s,'-]*$/.test(address.value)) {
            address.nextElementSibling.innerText = 'Please enter a valid address';
            error = true;
        } else {
            address.nextElementSibling.innerText = '';
        }

        if (etype.value === 'None') {
            etype.nextElementSibling.innerText = 'Please select an electronic type';
            error = true;
        } else {
            etype.nextElementSibling.innerText = '';
        }

        // if (electrician.value === 'None') {
        //     electrician.nextElementSibling.innerText = 'Please select an electrician';
        //     error = true;
        // } else {
        //     electrician.nextElementSibling.innerText = '';
        // }

        if (defective.value === '') {
            defective.nextElementSibling.innerText = 'Please enter your defective';
            error = true;
        } else {
            defective.nextElementSibling.innerText = '';
        }

        if (shipping.value === 'None') {
            shipping.nextElementSibling.innerText = 'Please select a shipping option';
            error = true;
        } else {
            shipping.nextElementSibling.innerText = '';
        }

        if (date.value === '') {
            date.nextElementSibling.innerText = 'Please select a date';
            error = true;
        } else {
            date.nextElementSibling.innerText = '';
        }

        if (completed.value === '') {
            completed.nextElementSibling.innerText = 'Please select a completion date';
            error = true;
        } else {
            completed.nextElementSibling.innerText = '';
        }

        if (payment.value === '') {
            payment.nextElementSibling.innerText = 'Please enter a payment amount';
            error = true;
        } else {
            payment.nextElementSibling.innerText = '';
        }

        if (error) {
            event.preventDefault(); // Prevent form submission if there are errors
        } else {
            // Submit form to server if there are no errors
            // You can use AJAX to submit the form asynchronously, or just let it submit normally
        }
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
