<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

// $parts = "active";

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
                                <i class="fas fa-dolly-flatbed menu-icon"></i>
                            </span> Electronic Parts
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
                                        data-bs-target="#addsubcategModal">
                                        <i class=" mdi mdi-plus ">Subcategory</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mg-btm d-flex justify-content-between">
                                        <div class="col-sm-12 flex ">
                                            <h4 class="card-title">Electronics</h4>
                                            <div>
                                                <button class="btn btn-success btn-fw btn-edit minimize"><i
                                                        class="fas fa-minus text-white"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 grid-margin" id="table-container">
                                            <div class="table-responsive">
                                                <table id="myDataTable" class="table table-hover">
                                                    <thead>
                                                        <tr class="bg-our">
                                                            <th> # </th>
                                                            <th> Electronic Name </th>
                                                            <th> Sub Category </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                        <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM elec_sub_categ
                                                    LEFT JOIN electronics ON electronics.elec_id = elec_sub_categ.elec_id";

                                                    
                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $warrantys = $row['warranty_num'] . " " . $row['warranty_unit'];
                                                        $partnum = rand(10000000000, 99999999999);
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['elec_name'] . '</td>';
                                                        echo '<td>' . $row['subcateg_name'] . '</td>';

                                                        echo '<td>';
                                                        echo '<button class="icns editparts editelec" id="' .  $row['elec_sub_categ_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</button>';
                                                        echo '<a class="icns" href="delete-electronics.php?rowid=' .  $row['elec_sub_categ_id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';

                                                        $id++;

                                                        $elec_sub_categ_id = $row['elec_sub_categ_id'];
                                                        $_SESSION['elec_sub_categ_id'] = $elec_sub_categ_id;

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

    <?php require_once 'modal.php'; ?>

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
    j(document).ready(function() {
        j('#myDataTable').DataTable();
    });
    </script>


    <script>
    $(document).ready(function() {
        $('#myDataTable').on('click', '.editparts', function() {
            id = $(this).attr('id');
            $.ajax({
                url: 'update-categ.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.suppbody').html(result);
                }
            });

            $('#editcategModal').modal('show');
        });

    });
    </script>

    <script>

    function initializeSelect2() {
        $('.js-example-basic-multiple').select2();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeSelect2();
    });
    </script>

<script>
    const form = document.querySelector('.form-sample');
    const subname = form.querySelector('input[name="subname"]');
    const electronic_type = form.querySelector('#electronic_type');

    electronic_type.addEventListener('change', () => {
        if (electronic_type.value !== 'None') {
            electronic_type.nextElementSibling.innerText = '';
        }
    });

    form.addEventListener('submit', (event) => {
        let error = false;


        if (subname.value === '') {
            subname.nextElementSibling.innerText = 'This field is required';
            error = true;
        } else {
            subname.nextElementSibling.innerText = '';
        }


        if (electronic_type.value === 'None') {
            electronic_type.nextElementSibling.innerText = 'Please select electronic type';
            error = true;
        } else {
            electronic_type.nextElementSibling.innerText = '';
        }


        if (error) {
            event.preventDefault(); // Prevent form submission if there are errors
        } else {
            // Submit form to server if there are no errors
            // You can use AJAX to submit the form asynchronously, or just let it submit normally
        }
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</body>

</html>