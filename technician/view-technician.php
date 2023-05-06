<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');





$rowid = $_GET['rowid'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT *
            FROM technician
            JOIN accounts ON technician.account_id = accounts.account_id
            WHERE technician.tech_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

$techactive = "active";



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
                            <i class="fas fa-users menu-icon"></i>
                            </span> Technician<span class="bread"></span>
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
                        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                
                                <a href="technicians.php">
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
                                                <th class="bg-gryy">Technician Name:</th>
                                                <td><?php echo $row['fname'] ." " .  $row['lname']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Address:</th>
                                                <td><?php echo $row['address']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Contact:</th>
                                                <td><?php echo $row['phone']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Email:</th>
                                                <td><?php echo $row['email']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Area of expertise:</th>
                                                <td><?php echo $row['expertise']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Repair limit:</th>
                                                <td><?php echo $row['limit_per_day']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Profile:</th>
                                                <td class="maxwidth">
                                                        <?php 
                $image1 = $row['tech_img'];
                $image_data1 = base64_encode($image1);
                $image_src1 = "data:image/jpeg;base64,{$image_data1}";
            ?>
                                                        <img class="imgsz" src="<?php echo $image_src1; ?>" alt="Technician's Profile Picture">
                                                    </td>
                                            </tr>
                                            <tr>
                                                <?php
                                                 $statusClass = '';
                                                 if ($row['status'] == 'Working') {
                                                     $statusClass = 'badge-gradient-warning';
                                                 } else if ($row['status'] == 'Inactive') {
                                                     $statusClass = 'badge-gradient-danger';
                                                 } else if ($row['status'] == 'Active') {
                                                     $statusClass = 'badge-gradient-success';
                                                 } else {
                                                     $statusClass = 'badge-gradient-secondary';
                                                 }
                                                
                                                echo'<th class="bg-gryy">Status:</th>';
                                                echo '<td><label class="badge ' . $statusClass . '">' . $row['status'] . '</label></td>';
                                                ?>
                                            </tr>
                                        </table>
                                        <div class="btn-group-sm d-flex btn-details">
                                        <?php
                                            echo '<a href="edit-technician.php?&rowid=' .  $row['tech_id'] . '" class="btn btn-success btn-fw">Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            echo '<a href="delete-technician.php&rowid=' .  $row['tech_id'] . '" class="btn btn-danger btn-fw red">Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';
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