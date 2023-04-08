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
                                <i class="fas fa-dolly-flatbed menu-icon"></i>
                            </span> Elecetronic Parts
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
                                        data-bs-target="#addPartsModal">
                                        <i class=" mdi mdi-plus ">Part</i>
                                    </button>
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addProductModal">
                                        <i class=" mdi mdi-plus ">Electronic</i>
                                    </button>
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addSuppModal">
                                        <i class=" mdi mdi-plus ">Brand</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm">
                                <div class="col-sm-12 col-md-6 flex">
                                    <h4 class="card-title">List of Electronic Parts</h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Part # </th>
                                                    <th> Part Name </th>
                                                    <th> Electornic type </th>
                                                    <th> Brand </th>
                                                    <th> Price </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM brand_parts
                                                    INNER JOIN elec_brand ON brand_parts.eb_id = elec_brand.eb_id
                                                    INNER JOIN electronics ON brand_parts.elec_id = electronics.elec_id";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $partnum = rand(10000000000, 99999999999);
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $partnum . '</td>';
                                                        echo '<td>' . $row['bp_name'] . '</td>';
                                                        echo '<td>' . $row['elec_name'] . '</td>';
                                                        echo '<td>' . $row['eb_name'] . '</td>';
                                                        echo '<td>₱ ' . $row['bp_cost'] . '</td>';

                                                        echo '<td>';
                                                        echo '<button class="icns editparts" id="' .  $row['bp_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</button>';
                                                        echo '<a class="icns" href="delete-parts.php?rowid=' .  $row['bp_id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $bp_id = $row['bp_id'];
                                                        $_SESSION['bp_id'] = $bp_id;

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

    <div class="modal fade " id="addPartsModal" tabindex="-1" aria-labelledby="editSuppModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuppModalLabel">Create New</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body suppbody">
                    <form method="POST" action="add-parts.php" enctype="multipart/form-data"
                        onsubmit="return validateForm()">
                        <div class="mb-3">
                            <label for="partname" class="form-label">Part Name</label>
                            <input type="text" class="form-control" name="partname" id="partname">
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="electronic" class="form-label">Electronic Type</label>
                            <select name="electronic" id="electronic" class="form-select">
                                <option value="None">--- Select ---</option>
                                <?php
                                $sql = "SELECT * FROM electronics";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['elec_id'] . "'>" . $row['elec_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select name="brand" id="brand" class="form-select">
                                <option value="None">--- Select ---</option>
                                <?php
                                $sql = "SELECT * FROM elec_brand";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['eb_id'] . "'>" . $row['eb_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price">
                            <span class="error"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input name="submit" type="submit" class="btn btn-danger" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="editPartsModal" tabindex="-1" aria-labelledby="editSuppModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuppModalLabel">Update Parts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body suppbody">

                </div>
            </div>
        </div>
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
        j('#myDataTable2').DataTable();
    });
    </script>

    <script>
    $(document).ready(function() {
        j(document).ready(function() {
            j('#myDataTable').DataTable();
        });

        $('.addparts').click(function() {
            $('#editSuppModal').modal('show');
        });

        // Use event delegation for handling click events on edit buttons
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
        const errorSpan = element.parentElement.querySelector(".error");
        errorSpan.textContent = message;
    }

    function clearError(element) {
        const errorSpan = element.parentElement.querySelector(".error");
        errorSpan.textContent = "";
    }

    function validateForm() {
        const partname = document.getElementById("partname");
        const electronic = document.getElementById("electronic");
        const brand = document.getElementById("brand");
        const price = document.getElementById("price");

        let isValid = true;

        if (!partname.value.trim()) {
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



</body>

</html>