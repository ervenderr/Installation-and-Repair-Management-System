<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$prodactive = "active";
$rowid = $_GET['rowid'];
$_SESSION['rowid'] = $rowid;
// Perform the query to retrieve the data for the selected row
$query = "SELECT * FROM products WHERE products.product_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

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
                            </span> Products <span class="bread">/ Update product info</span>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <a href="products.php">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span></span><i
                                            class=" mdi mdi-arrow-left-bold icon-sm text-primary align-middle">Back
                                        </i>
                                    </li>
                                </a>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-sample" action="edit-process.php" method="POST"
                                        enctype="multipart/form-data">
                                        <?php
                                        $query6 = "SELECT * FROM products 
                                        LEFT JOIN category ON products.categ_id = category.categ_id
                                        WHERE products.product_id = '" . $rowid . "';";
                                        $result6 = mysqli_query($conn, $query6);
                                        
                                        // Check if the query was successful and output the data
                                        if (mysqli_num_rows($result6) > 0) {
                                            $row6 = mysqli_fetch_assoc($result6);

                                        }
                                        $selected_category_id = $row6['categ_id'];
                                        ?>
                                        <p class="card-description">Update Product info </p>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="category">Category</label>
                                                    <div class="">
                                                        <select name="category" id="" class="form-control">
                                                            <option value="None">--- Select ---</option>
                                                            <?php
                                                                $sql2 = "SELECT * FROM category";
                                                                $result3 = mysqli_query($conn, $sql2);
                                                                while ($category = mysqli_fetch_assoc($result3)) {
                                                                    $categ_id = mysqli_real_escape_string($conn, $category['categ_id']);
                                                                    $selected = ($categ_id == $selected_category_id) ? "selected" : "";
                                                                    echo "<option value='{$categ_id}' {$selected}>{$category['categ_name']}</option>";
                                                                }                                                        
                                                                ?>
                                                        </select>
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="pname">Product Name</label>
                                                    <div class="">
                                                        <input type="text" name="pname" class="form-control"
                                                            value="<?php echo $row6['name']; ?>" />
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="price">Price</label>
                                                    <div class="">
                                                        <input type="number" step=".01" name="price"
                                                            class="form-control"
                                                            value="<?php echo $row6['price']; ?>" />
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="description" class="col-form-label">Description</label>
                                                    <div class="">
                                                        <input name="description" class="form-control" type="text"
                                                            value="<?php echo $row6['description']; ?>">
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="img1">Image 1</label>
                                                    <div class="">
                                                        <input type="file" class="form-control" id="img1" name="img1"
                                                            value="" />
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="img2">Image 2</label>
                                                    <div class="">
                                                        <input type="file" class="form-control" id="img2" name="img2" />
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-form-label" for="img3">Image 3</label>
                                                    <div class="">
                                                        <input type="file" class="form-control" id="img3" name="img3" />
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="features" class="col-form-label">Features</label>
                                                    <div class="">
                                                        <textarea class="form-control" name="features"
                                                            rows="10"><?php echo $row6['features']; ?></textarea>
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="full" class="col-form-label">Full Descriptions</label>
                                                    <div class="">
                                                        <textarea class="form-control" name="full"
                                                            rows="10"><?php echo $row6['full_descriptions']; ?></textarea>
                                                        <span class="error-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal"><a href="sample.php">Close</a>
                                                    Close</button>
                                                <input name="submit" type="submit" class="btn btn-primary"
                                                    value="Update Product" />

                                            </div>
                                    </form>
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
        const form = document.querySelector('.form-sample');
        const pname = form.querySelector('input[name="pname"]');
        const price = form.querySelector('input[name="price"]');
        // const email = form.querySelector('input[name="email"]');
        const description = form.querySelector('input[name="description"]');
        const full = form.querySelector('textarea[name="full"]');
        const features = form.querySelector('textarea[name="features"]');


        form.addEventListener('submit', (event) => {
            let error = false;

            if (pname.value === '') {
                pname.nextElementSibling.innerText = 'Please enter a Product name';
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

            if (description.value === '') {
                description.nextElementSibling.innerText = 'Please enter a description';
                error = true;
            } else {
                description.nextElementSibling.innerText = '';
            }

            if (full.value === '') {
                full.nextElementSibling.innerText = 'Please enter the full descriptions of the product';
                error = true;
            } else {
                full.nextElementSibling.innerText = '';
            }

            if (features.value === '') {
                features.nextElementSibling.innerText = 'Please enter the features of the product';
                error = true;
            } else {
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