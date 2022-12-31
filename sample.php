<?php

// Include the database configuration file
require_once 'dbconfig.php';

$page_title = 'ProtonTech | Services';
$services = 'actives';
include_once('homeIncludes/header.php');

?>

<body>
    <?php include_once('homeIncludes/homenav.php'); ?>

    <div class="container servicecon">
        <h2 class="text-center mb-5">SERVICES</h2>

        <?php

        // Retrieve the name, description, and image for all rows in the services table
        $sql = "SELECT name, description, image FROM services";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output the name, description, and image for each row
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $description = $row['description'];
                $image = $row['image'];

                // Convert the image data to a base64-encoded string
                $image_data = base64_encode($image);
                $image_src = "data:image/jpeg;base64,{$image_data}";

                echo '<div class="row mt-5">';
                echo '<div class="col-md-6">';
                echo '<img src="' . $image_src . '" alt="' . $name . '" class="img-fluid rounded shadow-lg">';
                echo '</div>';
                echo '<div class="col-md-6 d-flex align-items-center">';
                echo '<div class="bg-light p-3 rounded shadow-lg destext">';
                echo '<h3 class="text-left font-weight-bold mb-0 servname">' . $name . '</h3>';
                echo '<p class="text-left font-italic text-secondary mt-1 mb-3">' . $description . '</p>';
                echo '<button class="btn btn-primary mt-3"><a href="/solar-panels" style="color: white;">Learn more</a></button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<hr class="my-5">';
            }
        } else {
            echo "No services found.";
        }

        mysqli_close($conn);

        ?>
        <hr class="my-5">
    </div>

<?php include_once('homeIncludes/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>