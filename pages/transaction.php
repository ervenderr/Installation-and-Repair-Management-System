<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login/login.php');
  }


include_once('../admin_includes/header.php');
include_once('../homeincludes/dbconfig.php');
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
                                <i class="mdi mdi-clipboard-text"></i>
                            </span> Repair Transaction
                        </h3>
                        <?php
                            if (isset($_GET['msg'])) {
                                $msg = $_GET['msg'];
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                '. $msg .'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            }

                            if (isset($_GET['msg2'])) {
                                $msg2 = $_GET['msg2'];
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                '. $msg2 .'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            }
                        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active btn-group-sm" aria-current="page">
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addTransactionModal">
                                        Add New Transaction <i class=" mdi mdi-plus "></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">List of Repair Transaction</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> Transaction Code </th>
                                                    <th> Customer </th>
                                                    <th> Status </th>
                                                    <th> Date </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
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

</body>

</html>
