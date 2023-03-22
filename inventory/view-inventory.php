<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');


$rowid = $_GET['prod_id'];
$_SESSION['rowid'] = $rowid;
// Perform the query to retrieve the data for the selected row
$query2 = "SELECT products.*, 
SUM(inventory.stock_in) as stock_in,
SUM(inventory.stockout) as stockout,
SUM(inventory.stock_in) - SUM(inventory.stockout) as total_stocks
FROM products
LEFT JOIN inventory ON products.product_id = inventory.product_id
WHERE products.product_id = '" . $rowid . "'
GROUP BY products.product_id;";

$result2 = mysqli_query($conn, $query2);


// Check if the query was successful and output the data
if (mysqli_num_rows($result2) > 0) {
    $row2 = mysqli_fetch_assoc($result2);

}

$invactive = "active";



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
                            </span> Inventory<span class="bread"> / <?php echo $row2['name']; ?></span>
                        </h3>
                        <?php
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                echo '<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                '. $msg .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }

            if (isset($_GET['msg2'])) {
                $msg2 = $_GET['msg2'];
                echo '<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                '. $msg2 .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        ?>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">

                                <a href="inventory.php">
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="bg-gryy">Product Name:</th>
                                                <td><?php echo $row2['name']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">SKU:</th>
                                                <td><?php echo $row2['sku']?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gryy">Images:</th>
                                                <td class="maxwidth"><?php
                                                $image1 = $row2['img1'];
                                                $image2 = $row2['img2'];
                                                $image3 = $row2['img3'];
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
                                            <tr>
    <th class="bg-gryy">Total Stocks:</th>
    <td><?php echo $row2['total_stocks'] < 0 ? 'Stockout' : $row2['total_stocks']; ?></td>
</tr>

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <div class="d-flex btn-group-sm supp">
                                            <h4>Stock Records</h4>
                                            <button type="button" class="btn addnew" data-bs-toggle="modal"
                                                data-bs-target="#addSuppModal">
                                                <i class=" mdi mdi-plus ">New</i>
                                            </button>
                                        </div>
                                        <table class="table table-hover" id="myDataTable">
                                            <thead>
                                                <tr class="bg-our">
                                                    <th> # </th>
                                                    <th> Supplier </th>
                                                    <th> Stock-in </th>
                                                    <th> Stock-in Date </th>
                                                    <th> Stock-Out </th>
                                                    <th> Stock-out Date </th>
                                                    <th> cost </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                                
                                                    // Perform the query
                                                    $query = "SELECT * FROM inventory
                                                            JOIN products ON products.product_id = inventory.product_id
                                                            JOIN supplier ON supplier.supplier_id = inventory.supplier_id
                                                            WHERE products.product_id = '" . $rowid . "'
                                                            ORDER BY inventory.stock_in_date DESC;";
                                                            $result = mysqli_query($conn, $query);
                                                            $id = 1;
                                                            $row = mysqli_fetch_assoc($result);
                                                            if($row){
                                                                $_SESSION['invId'] = $row['inv_id'];
                                                                while ($row) {
                                                                    $modalId = 'editInventoryModal-' . $id;
        
                                                                    echo '<tr>';
                                                                    echo '<td>' . $id . '</td>';
                                                                    echo '<td>' . $row['fname'] . '  ' . $row['lname'] . '</td>';
                                                                    echo '<td>' . $row['stock_in'] . '</td>';
                                                                    echo '<td>' . $row['stock_in_date'] . '</td>';
                                                                    echo '<td>' . $row['stockout'] . '</td>';
                                                                    echo '<td>' . $row['stock_out_date'] . '</td>';
                                                                    echo '<td>' . $row['cost'] . '</td>';
                                                                    echo '<td class="btn-group-sm">';
                                                                    echo '<button class="icns btn btn-info edit edit-invo" id="' .  $row['inv_id'] . '">';
                                                                    echo '<i class="fas fa-edit view-account" id="' .  $row['inv_id'] . '"></i>';
                                                                    echo '</button>';
                                                                    echo '<button class="icns btn btn-danger delete" id="' .  $row['inv_id'] . '">';
                                                                    echo '<i class="fas fa-trash-alt view-account" id="' .  $row['inv_id'] . '"></i>';
                                                                    echo '</button>';
                                                                    echo '</td>';
                                                                    echo '</tr>';
                                                                    $row = mysqli_fetch_assoc($result);
                                                                    $id++;
                                                                }
                                                        }else {
                                                            echo "No rows found";
                                                        }
                                                        ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group-sm d-flex btn-details">
                                <?php
                                            // echo '<a href="edit-product.php?&rowid=' .  $row['inv_id'] . '" class="btn btn-success btn-fw">Update Details   <i class="fas fa-edit text-white"></i></a>';
                                            // echo '<a href="delete-product.php&rowid=' .  $row['inv_id'] . '" class="btn btn-danger btn-fw red">Delete Details   <i class="fas fa-trash-alt text-white"></i></a>';
                                            ?>
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
                                <h5 class="modal-title" id="addSuppModalLabel">Add New</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="add-inventory.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="supplierSelect" class="form-label">Supplier</label>
                                        <select class="form-select" id="supplierSelect" name="supplierSelect">
                                            <option value="None">--- select ---</option>
                                            <?php
                                                // Query the supplier table
                                                $sql = "SELECT * FROM supplier";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row["supplier_id"] . "'>" . $row['fname'] . '  ' . $row['lname'] . "</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantityInput" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantityInput"
                                            name="quantityInput">
                                    </div>
                                    <div class="mb-3">
                                        <label for="stockInDateInput" class="form-label">Stock-in Date</label>
                                        <input type="date" class="form-control" id="stockInDateInput"
                                            name="stockInDateInput">
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


                <!--edit Modal -->
                <div class="modal fade" id="editSuppModal" tabindex="-1" aria-labelledby="editSuppModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSuppModalLabel">Edit record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body suppbody">

                            </div>
                        </div>
                    </div>
                </div>

                <!--delete Modal -->
                <div class="modal fade" id="deleteSuppModal" tabindex="-1" aria-labelledby="editSuppModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSuppModalLabel">Delete record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body delsupp">

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

    <script>
    $(document).ready(function() {
        $('.edit').click(function() {

            id = $(this).attr('id');
            $.ajax({
                url: 'edit-inventory.php',
                method: 'post',
                data: {
                    inv_id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.suppbody').html(result);
                }
            });


            $('#editSuppModal').modal('show');
        })
    })
    </script>

    <script>
    $(document).ready(function() {
        $('.delete').click(function() {

            id = $(this).attr('id');
            $.ajax({
                url: 'delete-inventory.php',
                method: 'post',
                data: {
                    inv_id: id
                },
                success: function(result) {
                    // Handle successful response
                    $('.delsupp').html(result);
                }
            });


            $('#deleteSuppModal').modal('show');
        })
    })
    </script>

    <script>
    // Set a timer to hide the alert after 3 seconds
    const alert = document.querySelector("#alert");
    if (alert) {
        setTimeout(() => {
            alert.style.display = "none";
        }, 2000);
    }
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