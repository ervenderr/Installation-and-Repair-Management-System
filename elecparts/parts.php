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
                                        data-bs-target="#addPartsModal">
                                        <i class=" mdi mdi-plus ">Part</i>
                                    </button>
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addelectronicModal">
                                        <i class=" mdi mdi-plus ">Electronic</i>
                                    </button>
                                    <button type="button" class="btn addnew" data-bs-toggle="modal"
                                        data-bs-target="#addeBrandModal">
                                        <i class=" mdi mdi-plus ">Brand</i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mg-btm d-flex justify-content-between">
                                <div class="col-sm-12 flex ">
                                    <h4 class="card-title">List of Electronic Parts</h4>
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
                    <div class="row">
                        <div class="col-sm-6">
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
                                                <table id="myDataTable3" class="table table-hover">
                                                    <thead>
                                                        <tr class="bg-our">
                                                            <th> # </th>
                                                            <th> Electronic Name </th>
                                                            <th> Warranty </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                        <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM electronics";

                                                    

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $warrantys = $row['warranty_num'] . " " . $row['warranty_unit'];
                                                        $partnum = rand(10000000000, 99999999999);
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['elec_name'] . '</td>';
                                                        echo '<td>' . $warrantys . '</td>';

                                                        echo '<td>';
                                                        echo '<button class="icns editparts editelec" id="' .  $row['elec_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</button>';
                                                        echo '<a class="icns" href="delete-electronics.php?rowid=' .  $row['elec_id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $elec_id = $row['elec_id'];
                                                        $_SESSION['elec_id'] = $elec_id;

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

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mg-btm d-flex justify-content-between">
                                        <div class="col-sm-12 flex ">
                                            <h4 class="card-title">Electronic Brands</h4>
                                            <div>
                                                <button class="btn btn-success btn-fw btn-edit minimize"><i
                                                        class="fas fa-minus text-white"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 grid-margin" id="table-container">
                                            <div class="table-responsive">
                                                <table id="myDataTable2" class="table table-hover">
                                                    <thead>
                                                        <tr class="bg-our">
                                                            <th> # </th>
                                                            <th> Brand Name </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                        <?php
                                                    // Perform the query
                                                    $query = "SELECT * FROM elec_brand";

                                                    $result = mysqli_query($conn, $query);
                                                    $id = 1;

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $partnum = rand(10000000000, 99999999999);
                                                        echo '<tr>';
                                                        echo '<td>' . $id . '</td>';
                                                        echo '<td>' . $row['eb_name'] . '</td>';

                                                        echo '<td>';
                                                        echo '<button class="icns editparts editbrand" id="' .  $row['eb_id'] . '">';
                                                        echo '<i class="fas fa-edit text-success view-account"></i>';
                                                        echo '</button>';
                                                        echo '<a class="icns" href="delete-brand.php?rowid=' .  $row['eb_id'] . '" onclick="return confirm(\'Are you sure you want to delete this record?\')">';
                                                        echo '<i class="fas fa-trash-alt text-danger view-account"></i>';
                                                        echo '</a>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $id++;

                                                        $eb_id = $row['eb_id'];
                                                        $_SESSION['eb_id'] = $eb_id;

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

        $('#myDataTable2').on('click', '.editbrand', function() {
            id = $(this).attr('id');
            $.ajax({
                url: 'update-brand.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.brandbody').html(result);
                }
            });

            $('#editbrandsModal').modal('show');
        });

        $('#myDataTable3').on('click', '.editelec', function() {
            id = $(this).attr('id');
            $.ajax({
                url: 'update-electronics.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.elecbody').html(result);
                }
            });

            $('#editelectronicsModal').modal('show');
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({});
    });

    function initializeSelect2() {
        $('.js-example-basic-multiple').select2();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeSelect2();
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

    function validateFormTwo() {
        const elecname = document.getElementById("elecname");
        const brands = document.getElementById("brands");
        const warranty_number = document.getElementById("warranty_number");

        let isValid = true;

        if (elecname.value === "") {
            showError(elecname, "Please enter an electronic name.");
            isValid = false;
        } else {
            clearError(elecname);
        }

        if (brands.value === "") {
            showError(brands, "Please select a brands.");
            isValid = false;
        } else {
            clearError(brands);
        }

        if (!warranty_number.value.trim() || parseFloat(warranty_number.value) <= 0) {
            showError(warranty_number, "Cannot be empty.");
            isValid = false;
        } else {
            clearError(warranty_number);
        }

        // Reinitialize Select2 after validation
        initializeSelect2();

        return isValid;
    }


    function validateFormThree() {

        const brands = document.getElementById("brandname");

        let isValid = true;

        if (brandname.value === "") {
            showError(brandname, "Cannot be empty.");
            isValid = false;
        } else {
            clearError(brandname);
        }


        return isValid;
    }

    function validateFormfour() {
        const updateForm = document.querySelector('form[action="update-brand.php"]');
        if (!updateForm) return false; // Return false if the form is not found

        const brandname = updateForm.querySelector("#brandname");

        let isValid = true;

        if (brandname.value === "") {
            showError(brandname, "Cannot be empty.");
            isValid = false;
        } else {
            clearError(brandname);
        }

        return isValid;
    }

    document.addEventListener('submit', function(event) {
        if (event.target.matches('form[action="update-brand.php"]')) {
            if (!validateFormfour()) {
                event.preventDefault();
            }
        }
    });

    function validateFormElectronicsUpdate() {
        const updateForm = document.querySelector('form[action="update-electronics.php"]');
        if (!updateForm) return false;

        const elecname = updateForm.querySelector("#elecnameUpdate");
        const brands = updateForm.querySelector("#brandsUpdate");
        const warranty_number = updateForm.querySelector("#warranty_numberUpdate");

        let isValid = true;

        if (elecname.value === "") {
            showError(elecname, "Please enter an electronic name.");
            isValid = false;
        } else {
            clearError(elecname);
        }

        if (brands.selectedOptions.length === 0) {
            showError(brands, "Please select a brand.");
            isValid = false;
        } else {
            clearError(brands);
        }

        if (!warranty_number.value.trim() || parseFloat(warranty_number.value) <= 0) {
            showError(warranty_number, "Cannot be empty.");
            isValid = false;
        } else {
            clearError(warranty_number);
        }
        initializeSelect2();

        return isValid;
    }

    document.addEventListener('submit', function(event) {
        if (event.target.matches('form[action="update-electronics.php"]')) {
            if (!validateFormElectronicsUpdate()) {
                event.preventDefault();
            }
        }
    });

    function validateFormPartsUpdate() {
    const updateForm = document.querySelector('form[action="update-parts.php"]');
    if (!updateForm) return false;

    const partname = updateForm.querySelector("#partname");
    const electronic = updateForm.querySelector("#electronic");
    const brand = updateForm.querySelector("#brand");
    const price = updateForm.querySelector("#price");

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

document.addEventListener('submit', function (event) {
    if (event.target.matches('form[action="update-parts.php"]')) {
        if (!validateFormPartsUpdate()) {
            event.preventDefault();
        }
    }
});

    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const minimizeBtn = document.querySelector('.btn-edit.minimize');
        const tableContainer = document.getElementById('table-container');
        const icon = minimizeBtn.querySelector('.fas');

        minimizeBtn.addEventListener('click', function() {
            tableContainer.classList.toggle('d-none');
            icon.classList.toggle('fa-minus');
            icon.classList.toggle('fa-chevron-down');
        });
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



</body>

</html>