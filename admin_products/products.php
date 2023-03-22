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
                            <i class="fas fa-box menu-icon"></i>
                            </span> Products
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
                            unset ($_SESSION['msg2']);
                            }
                        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active btn-group-sm" aria-current="page">
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addProductModal">
                                        <i class=" mdi mdi-plus ">Product</i>
                                    </button>
                                </li>
                                <li class="breadcrumb-item active btn-group-sm" aria-current="page">
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addSuppModal">
                                       <i class=" mdi mdi-plus ">Category</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
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
                                        <table id="myDataTable" class="table table-hover">
                                            <thead>
                                            <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> SKU </th>
                                                    <th> Name </th>
                                                    <th> Category </th>
                                                    <th> Price </th>
                                                    <th> Image </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM products
                                                    INNER JOIN category ON products.categ_id = category.categ_id";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $modalId = 'edittechnicianModal-' . $id;
                                                        $image = $row['img1'];
                                                        $image_data = base64_encode($image);
                                                        $image_src = "data:image/jpeg;base64,{$image_data}";
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['sku'] . '</td>';
                                                        echo '<td>' . $row['name'] . '</td>';
                                                        echo '<td>' . $row['categ_name'] . '</td>';
                                                        echo '<td>₱ ' . $row['price'] . '</td>';
                                                        echo '<td><img src="' . $image_src . '" alt="' . $row['name'] . '" class=""></td>';

                                                        $statusClass = '';
                                                        if ($row['status'] == 'Backordered') {
                                                            $statusClass = 'badge-gradient-warning';
                                                        } else if ($row['status'] == 'Inactive') {
                                                            $statusClass = 'badge-gradient-danger';
                                                        } else if ($row['status'] == 'In-Stock') {
                                                            $statusClass = 'badge-gradient-success';
                                                        } else {
                                                            $statusClass = 'badge-gradient-secondary';
                                                        }

                                                        echo '<td>';
                                                        echo '<a class="icns" href="view-product.php?rowid=' .  $row['product_id'] . '">';
                                                        echo '<i class="fas fa-eye text-primary view-account"></i>';
                                                        echo '</a>';
                                                        echo '<a class="icns" href="edit-product.php?rowid=' .  $row['product_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</a>';
                                                        echo '<a class="icns" href="delete-product.php?rowid=' .  $row['product_id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $product_id = $row['product_id'];
                                                        $_SESSION['product_id'] = $product_id;

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
                <!--Add Modal -->
                <div class="modal fade" id="addSuppModal" tabindex="-1" aria-labelledby="addSuppModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSuppModalLabel">Add New Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="add-category.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                        <label for="category" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="category"
                                            name="category">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <input name="submit" type="submit" class="btn btn-success" value="Save" />
                                    </div>
                                </form>
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
    j(document).ready(function() {
        j('#myDataTable').DataTable();
    });

    j(document).ready(function() {
        j('#myDataTable2').DataTable();
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
        }else {
            description.nextElementSibling.innerText = '';
        }

        if (img1.value === '') {
            img1.nextElementSibling.innerText = 'Please select main image';
            error = true;
        }else {
            img1.nextElementSibling.innerText = '';
        }
        
        if (img2.value === '') {
            img2.nextElementSibling.innerText = 'Please select 2nd image';
            error = true;
        }else {
            img2.nextElementSibling.innerText = '';
        }

        if (img3.value === '') {
            img3.nextElementSibling.innerText = 'Please select 3rd image';
            error = true;
        }else {
            img3.nextElementSibling.innerText = '';
        }

        if (full.value === '') {
            full.nextElementSibling.innerText = 'Please enter the full descriptions of the product';
            error = true;
        }else {
            full.nextElementSibling.innerText = '';
        }

        if (features.value === '') {
            features.nextElementSibling.innerText = 'Please enter the features of the product';
            error = true;
        }else {
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

</body>

</html>
