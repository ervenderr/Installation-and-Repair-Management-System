<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

require_once '../tools/variables.php';
$page_title = 'ProtonTech | Products';
$products = 'actives';
include_once('../homeIncludes/header.php');


?>

<body class="view-body">
    <?php include_once('../homeIncludes/homenav.php'); ?>


    <div class="container servicecon">
        <h2 class="serv text-center mb-5">PRODUCTS</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            // Check if there are any rows in the table
            if (mysqli_num_rows($result) > 0) {
                // If there are rows, output the name, price, description, and image for each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $full_description = $row['full_descriptions'];
                    $features = $row['features'];
                    $image1 = $row['img1'];
                    $image2 = $row['img2'];
                    $image3 = $row['img3'];

                    // Output the product information
                    echo '<div class="col">';
                    echo '<div class="product productview">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="' . $name . '" class="product-image" data-toggle="modal" data-target="#img-modal-' . $name . '">';
                    echo '<h2 class="serv">' . $name . '</h2>';
                    echo '<p>' . $description . '</p>';
                    echo '<div class="product-price">₱ ' . $price . '</div>';
                    echo '<button type="button" class="btn btn-primary seemore" data-toggle="modal" data-target="#img-modal-' . $name . '">See More</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // If there are no rows in the table, display a message
                echo "No products found.";
            }

            ?>



        </div>


        <?php include_once('../modals/img_modal.php'); ?>


        <!-- Include jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
            

        <!-- Custom script -->
        <script>
            function toggleDetails() {
                $('#product-details').toggle();
            }
        </script>


        <!-- Footer -->
        <?php include_once('../homeIncludes/footer.php'); ?>
</body>

</html>