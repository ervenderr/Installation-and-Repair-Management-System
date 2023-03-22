<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';





$rowid = $_GET['rowid'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT * FROM products WHERE products.product_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

$prodactive = "active";



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
                            </span> Products<span class="bread"> / <?php echo $row['name']; ?></span>
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

                            if (isset($_SESSION['msg'])) {
                                $msg2 = $_SESSION['msg'];
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                '. $msg2 .'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            unset ($_SESSION['msg']);
                            }
                        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                
                                <a href="products.php">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span><i class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                    </i>
                                </li></a>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="bg-gryy">Product Name:</th>
                                                <td><?php echo $row['name']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Price:</th>
                                                <td>₱ <?php echo $row['price']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Featured Description:</th>
                                                <td><?php echo $row['description']?></td>
                                            </tr>
                                            <tr class="fulldesc">
                                                <th class="bg-gryy">Full Description:</th>
                                                <td class="" style="white-space: normal; word-wrap: break-word;"><?php echo nl2br($row['full_descriptions'])?></td>
                                            </tr>
                                            <tr class="fulldesc">
                                                <th class="bg-gryy">Features:</th>
                                                <td class="" style="white-space: normal; word-wrap: break-word;"><?php echo nl2br($row['features'])?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Images:</th>
                                                <td class="maxwidth"><?php
                                                $image1 = $row['img1'];
                                                $image2 = $row['img2'];
                                                $image3 = $row['img3'];
                                                $image_data1 = base64_encode($image1);
                                                $image_data2 = base64_encode($image2);
                                                $image_data3 = base64_encode($image3);
                                                $image_src1 = "data:image/jpeg;base64,{$image_data1}";
                                                $image_src2 = "data:image/jpeg;base64,{$image_data2}";
                                                $image_src3 = "data:image/jpeg;base64,{$image_data3}";
                                                echo 
                                                '<img class="imgsz" src="' . $image_src1 . '" alt="img1" class="">
                                                <img class="imgsz" src="' . $image_src3 . '" alt="img2" class="">
                                                <img class="imgsz" src="' . $image_src2 . '" alt="img3" class="">';
                                                ?></td>
                                            </tr>
                                            
                                        </table>
                                        <div class="btn-group-sm d-flex btn-details">
                                            <?php
                                            echo '<a href="edit-product.php?&rowid=' .  $row['product_id'] . '" class="btn btn-success btn-fw">Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            echo '<a href="delete-product.php?&rowid=' .  $row['product_id'] . '" class="btn btn-danger btn-fw red">Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
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