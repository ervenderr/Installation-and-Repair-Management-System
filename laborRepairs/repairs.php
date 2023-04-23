<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$labors = "active";
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
                                <i class="fas fa-wrench menu-icon"></i>
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
                                    <button type="button" class="btn addnew addparts" data-bs-toggle="modal"
                                        data-bs-target="#addRepairsModal">
                                        <i class=" mdi mdi-plus ">Repair Service</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm d-flex justify-content-between">
                                <div class="col-sm-12 flex ">
                                    <h4 class="card-title">List of Repair services</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin" id="table-container">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Service Name </th>
                                                    <th> Electronic Type </th>
                                                    <th> Price </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM common_repairs
                                                    INNER JOIN electronics ON common_repairs.elec_id = electronics.elec_id";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $partnum = rand(10000000000, 99999999999);
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['comrep_name'] . '</td>';
                                                        echo '<td>' . $row['elec_name'] . '</td>';
                                                        echo '<td>₱ ' . $row['comrep_cost'] . '</td>';

                                                        echo '<td>';
                                                        echo '<button class="icns editparts" id="' .  $row['comrep_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</button>';
                                                        echo '<a class="icns" href="delete-repairs.php?rowid=' .  $row['comrep_id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $comrep_id = $row['comrep_id'];
                                                        $_SESSION['comrep_id'] = $comrep_id;

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
    $(document).ready(function() {
        $('#myDataTable').on('click', '.editparts', function() {
            id = $(this).attr('id');
            $.ajax({
                url: 'update-repairs.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.suppbody').html(result);
                }
            });

            $('#editRepairsModal').modal('show');
        });

    });
    </script>

    <script>
    j(document).ready(function() {
        j('#myDataTable').DataTable();
        j('#myDataTable2').DataTable();
        j('#myDataTable3').DataTable();
    });
    </script>

    <script>
    $(document).ready(function() {
        $('#myDataTable').on('click', '.editparts', function() {
            id = $(this).attr('id');
            $.ajax({
                url: 'update-parts.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.suppbody').html(result);
                }
            });

            $('#editPartsModal').modal('show');
        });

    });
    </script>



    <script>
    function showError(element, message) {
        const errorSpan = element.nextElementSibling;
        errorSpan.textContent = message;
        element.classList.add("is-invalid");
    }

    function clearError(element) {
        const errorSpan = element.nextElementSibling;
        errorSpan.textContent = "";
        element.classList.remove("is-invalid");
    }

    function validateForm() {
        const partname = document.getElementById("partname");
        const electronic = document.getElementById("electronic");
        const brand = document.getElementById("brand");
        const price = document.getElementById("price");

        let isValid = true;

        if (partname.value === "") {
            showError(partname, "Please enter a part name.");
            isValid = false;
        } else {
            clearError(partname);
        }

        if (electronic.value === "None") {
            showError(electronic, "Please select an electronic type.");
            isValid = false;
        } else {
            clearError(electronic);
        }

        if (brand.value === "None") {
            showError(brand, "Please select a brand.");
            isValid = false;
        } else {
            clearError(brand);
        }


        if (!price.value.trim() || parseFloat(price.value) <= 0) {
            showError(price, "Please enter a valid price.");
            isValid = false;
        } else {
            clearError(price);
        }

        return isValid;
    }
    </script>


    <script>
        $(document).ready(function() {
            $('#electronic_type').change(function() {
                var elec_id = $(this).val();

                if (elec_id === "None") {
                    $('#defective').html('<option value="None">--- Select ---</option>');
                } else {
                    $.ajax({
                        url: 'get_electronic_parts.php',
                        type: 'POST',
                        data: {
                            elec_id: elec_id
                        },
                        dataType: 'json',
                        success: function(data) {
                            var options = '<option value="None">--- Select ---</option>';
                            for (var i = 0; i < data.length; i++) {
                                options += '<option value="' + data[i].bp_id + '">' + data[
                                        i]
                                    .bp_name + '</option>';

                            }
                            $('#electronic_part').html(options);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>