<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$packages = "active";

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
    header('location: ../login/login.php');
  }

  $rowid = $_GET['rowid'];
  $_SESSION['rowid'] = $rowid;
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT *, package.price AS package_price, services.price AS service_price, package.status AS package_status
FROM package
INNER JOIN services ON package.service_id = services.service_id
WHERE package.PKG_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_assoc($result);

}
$currentStatus = $rows['package_status'];
$service = $rows['service_name'];
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
                            </span> Package<span class="bread"> / Update <?php echo $rows['name']; ?></span>
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
                                <a href="packages.php">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span></span><i
                                            class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                        </i>
                                    </li>
                                </a>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="bg-gryy">Service Type:</th>
                                                    <td><?php echo $rows['service_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-gryy">Package Name:</th>
                                                    <td><?php echo $rows['name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-gryy">Price:</th>
                                                    <td><?php echo $rows['package_price']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-gryy">Featured Description:</th>
                                                    <td><textarea readonly rows="7"
                                                            cols="90"><?php echo $rows['descriptions']; ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-gryy">Images:</th>
                                                    <td class="maxwidth">
                                                        <?php 
                $image1 = $rows['image'];
                $image_data1 = base64_encode($image1);
                $image_src1 = "data:image/jpeg;base64,{$image_data1}";
            ?>
                                                        <img class="imgsz" src="<?php echo $image_src1; ?>" alt="img1">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                     $statusClass = '';
                                                        
                                                     if ($rows['package_status'] == 'Inactive') {
                                                         $statusClass = 'badge-gradient-secondary';
                                                     } else {
                                                         $statusClass = 'badge-gradient-success';
                                                     }
                                                     ?>
                                                    <th class="bg-gryy">Status</th>
                                                    <td><label
                                                            class="badge <?php echo $statusClass ?>"><?php echo $rows['package_status'] ?></label>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="btn-group-sm d-flex btn-details">
                                        <a href="update-package.php?rowid=<?php echo $rows['pkg_id']; ?>"
                                            class="btn btn-success btn-fw">
                                            Update Details <i class="fas fa-edit text-white"></i>
                                        </a>
                                        <a href="delete-package.php?rowid=<?php echo $rows['pkg_id']; ?>"
                                            class="btn btn-danger btn-fw red"
                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                            Delete Details <i class="fas fa-trash-alt text-white"></i>
                                        </a>

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