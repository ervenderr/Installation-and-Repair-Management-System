<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$packages = "active";

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
                            </span> Packages
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
                                        data-bs-target="#addpackageModal">
                                        <i class=" mdi mdi-plus ">Package</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex">
                                    <h4 class="card-title">List of Packages</h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Service </th>
                                                    <th> Package name </th>
                                                    <th> price </th>
                                                    <th> description </th>
                                                    <th> image </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    // Perform the query
                                                    $query = "SELECT *, package.price AS package_price, services.price AS service_price, package.status AS package_status
                                                    FROM package
                                                    INNER JOIN services ON package.service_id = services.service_id";
                                          

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $statusClass = '';
                                                        
                                                        if ($row['package_status'] == 'Inactive') {
                                                            $statusClass = 'badge-gradient-secondary';
                                                        } else {
                                                            $statusClass = 'badge-gradient-success';
                                                        }


                                                        $modalId = 'edittechnicianModal-' . $id;
                                                        $image = $row['image'];
                                                        $image_data = base64_encode($image);
                                                        $image_src = "data:image/jpeg;base64,{$image_data}";
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['service_name'] . '</td>';
                                                        echo '<td>' . $row['name'] . '</td>';
                                                        echo '<td>' . $row['package_price'] . '</td>';
                                                        echo '<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">' . $row['description'] . '</td>';
                                                        echo '<td><img src="' . $image_src . '" alt="' . $row['name'] . '" class=""></td>';
                                                        echo '<td><label class="badge ' . $statusClass . '">' . $row['package_status'] . '</label></td>';

                                                        

                                                        echo '<td>';
                                                        echo '<a class="icns viewmodal editparts" href="view-package.php?rowid=' .  $row['pkg_id'] . '">';
                                                        echo '<i class="fas fa-eye text-primary view-account"></i>';
                                                        echo '</a>';
                                                        echo '<a class="icns editparts editmodal" editparts" href="update-package.php?rowid=' .  $row['pkg_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</a>';
                                                        echo '<a class="icns" href="delete-package.php?rowid=' .  $row['pkg_id'] . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $pkg_id = $row['pkg_id'];
                                                        $_SESSION['pkg_id'] = $pkg_id;

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

                <?php include_once('../modals/add-package.php') ?>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>




    <script>
    const form = document.querySelector('.form-sample');
    const sname = document.getElementById('sname');
    const pname = form.querySelector('input[name="pname"]');
    const price = form.querySelector('input[name="price"]');
    const description = form.querySelector('textarea[name="description"]');
    const img1 = form.querySelector('input[name="img1"]');


    form.addEventListener('submit', (event) => {
        let error = false;

        if (sname.value === "None") {
            sname.nextElementSibling.innerText = 'Please select a Service Type';
            error = true;
        } else {
            sname.nextElementSibling.innerText = '';
        }

        if (pname.value === '') {
            pname.nextElementSibling.innerText = 'Please enter a Package name';
            error = true;
        } else {
            pname.nextElementSibling.innerText = '';
        }

        if (price.value === '') {
            price.nextElementSibling.innerText = 'Please enter a Service name';
            error = true;
        } else {
            price.nextElementSibling.innerText = '';
        }


        if (description.value === '') {
            description.nextElementSibling.innerText = 'Please enter a description';
            error = true;
        } else {
            description.nextElementSibling.innerText = '';
        }

        if (img1.value === '') {
            img1.nextElementSibling.innerText = 'Please select image';
            error = true;
        } else {
            img1.nextElementSibling.innerText = '';
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