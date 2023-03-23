<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');


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
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon text-white me-2">
                                <i class="fas fa-warehouse menu-icon"></i>
                            </span> Inventory
                        </h3>
                        <?php
                        if (isset($_GET['msg'])) {
                            $msg = $_GET['msg'];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            '. $msg .'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }

                        if (isset($_GET['msg2'])) {
                            $msg2 = $_GET['msg2'];
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            '. $msg2 .'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                    ?>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex">
                                    <h4 class="card-title">List of Products</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="myDataTable">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> SKU </th>
                                                    <th> Name </th>
                                                    <th> cost </th>
                                                    <th> Stock-in </th>
                                                    <th> Stock-out </th>
                                                    <th> status </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    
                                                
                                                    // Perform the query
                                                    $query = "SELECT COALESCE(products.product_id, 0) AS product_id,
                                                                    COALESCE(products.sku, '') AS sku,
                                                                    COALESCE(products.status, '') AS status,
                                                                    COALESCE(products.name, '') AS name,
                                                                    COALESCE(SUM(inventory.stock_in), 0) AS total_qty,
                                                                    COALESCE(MAX(inventory.stockout), NULL) AS stockout,
                                                                    COALESCE(inventory.cost, '') AS cost
                                                            FROM products
                                                            LEFT JOIN inventory ON products.product_id = inventory.product_id
                                                            GROUP BY products.product_id";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $modalId = 'editInventoryModal-' . $id;
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['sku'] . '</td>';
                                                        echo '<td>' . $row['name'] . '</td>';
                                                        echo '<td>' . $row['cost'] . '</td>';
                                                        echo '<td>' . $row['total_qty'] . '</td>';
                                                        echo '<td>' . $row['stockout'] . '</td>';
                                                
                                                        // Determine status
                                                        $statusText = $row['status'];
                                                        if ($row['total_qty'] == 0) {
                                                            $statusText = 'Out of Stock';
                                                            $statusClass = 'badge-gradient-danger';
                                                        } else {
                                                            if ($row['status'] == 'Backordered') {
                                                                $statusClass = 'badge-gradient-warning';
                                                            } else if ($row['status'] == 'Inactive') {
                                                                $statusClass = 'badge-gradient-danger';
                                                            } else if ($row['status'] == 'In-Stock') {
                                                                $statusClass = 'badge-gradient-success';
                                                            } else {
                                                                $statusText = 'In-Stock';
                                                                $statusClass = 'badge-gradient-success';
                                                            }
                                                        }
                                                
                                                        echo '<td><label class="badge ' . $statusClass . '">' . $statusText . '</label></td>';
                                                        echo '<td class="btn-group-sm">';
                                                        if ($row['product_id'] != 0) {
                                                            echo '<a class="icns btn btn-info" href="view-inventory.php?prod_id=' .  $row['product_id'] . '">';
                                                            echo 'View <i class="fas fa-eye view-account" Prod_id="' .  $row['product_id'] . '"></i>';
                                                            echo '</a>';
                                                        }
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

                <?php include_once('../modals/add-product-modal.php') ?>
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
    });
    </script>

    <script>
    const form = document.querySelector('.form-sample');
    const pname = form.querySelector('input[name="pname"]');
    const price = form.querySelector('input[name="price"]');
    // const email = form.querySelector('input[name="email"]');
    const description = form.querySelector('input[name="description"]');
    const img1 = form.querySelector('input[name="img1"]');
    const img2 = form.querySelector('input[name="img2"]');
    const img3 = form.querySelector('input[name="img3"]');
    const full = form.querySelector('textarea[name="full"]');
    const features = form.querySelector('textarea[name="features"]');


    form.addEventListener('submit', (event) => {
        let error = false;

        if (pname.value === '') {
            pname.nextElementSibling.innerText = 'Please enter a Product name';
            error = true;
        } else if (!/^[A-Z][a-z]*$/.test(pname.value)) {
            pname.nextElementSibling.innerText = 'First Letter of Product name should be capitalized';
            error = true;
        } else {
            pname.nextElementSibling.innerText = '';
        }

        if (price.value === '') {
            price.nextElementSibling.innerText = 'Please enter a price';
            error = true;
        } else {
            price.nextElementSibling.innerText = '';
        }

        // if (email.value === '') {
        //     email.nextElementSibling.innerText = 'Please enter your email';
        //     error = true;
        // } else {
        //     email.nextElementSibling.innerText = '';
        // }

        if (description.value === '') {
            description.nextElementSibling.innerText = 'Please enter a description';
            error = true;
        } else {
            description.nextElementSibling.innerText = '';
        }

        if (img1.value === '') {
            img1.nextElementSibling.innerText = 'Please select main image';
            error = true;
        } else {
            img1.nextElementSibling.innerText = '';
        }

        if (img2.value === '') {
            img2.nextElementSibling.innerText = 'Please select 2nd image';
            error = true;
        } else {
            img2.nextElementSibling.innerText = '';
        }

        if (img3.value === '') {
            img3.nextElementSibling.innerText = 'Please select 3rd image';
            error = true;
        } else {
            img3.nextElementSibling.innerText = '';
        }

        if (full.value === '') {
            full.nextElementSibling.innerText = 'Please enter the full descriptions of the product';
            error = true;
        } else {
            full.nextElementSibling.innerText = '';
        }

        if (features.value === '') {
            features.nextElementSibling.innerText = 'Please enter the features of the product';
            error = true;
        } else {
            features.nextElementSibling.innerText = '';
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