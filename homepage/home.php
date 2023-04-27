<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
$page_title = 'ProtonTech | Home';
include_once('../homeIncludes/header.php');
require_once '../tools/variables.php';
$home = 'actives';



?>


<body>
    <?php include_once('../homeIncludes/homenav.php');?>

    <div id="particles-js"></div>
    <div class="showcase-area hidden">
        <div class="container">
            <div class="left">
                <div class="big-title">
                    <h1>Start Exploring now.</h1>
                </div>
                <p class="texts">
                    We offer a wide range of repair for most types of electronics and
                    Job orders like CCTV installation. Simply fill out our online form
                    to request a repair or Job order and one of our technicians will
                    be in touch with you soon.
                </p>
                <div class="req">
                    <p>
                        <a class="btn btn-outline-success log2" role="submit" href="../service/services.php">Request a custom service</a>

                    </p>
                    <p>
                        <a class="btn btn-outline-success log1" role="submit" href="../repair/repair.php">Request a Repair</a>

                    </p>
                </div>
            </div>

            <div class="right">
                <img src="../img/seccam.png" alt="cctv Image" class="person" />
            </div>
        </div>
    </div>

    

    <!-- Featured Services -->
    <div class="container mt-5 values-section">
        <h2 class="text-center mb-5">Featured Services </h2>
        <div class="">
            <?php 
                $sql = "SELECT service_name, description, img FROM services LIMIT 2";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['service_name'];
                    $description = $row['description'];
                    $image = $row['img'];
                    $image_data = base64_encode($image);
                    $image_src = "data:image/jpeg;base64,{$image_data}";
                    echo '<div class="row mt-5">';
                    echo '<div class="col-md-6 serimg hidden">';
                    echo '<img src="' . $image_src . '" alt="' . $name . '" class="img-fluid rounded shadow-lg imgserv">';
                    echo '</div>';
                    echo '<div class="col-md-6 d-flex align-items-center hidden">';
                    echo '<div class="bg-light p-3 rounded shadow-lg destext">';
                    echo '<h3 class="serv text-left font-weight-bold mb-0 servname">' . $name . '</h3>';
                    echo '<p class="text-left font-italic text-secondary mt-1 mb-3">' . $description . '</p>';
                    echo '<button class="btn btn-primary mt-3 serbtn"><a href="/solar-panels" style="color: white;">Learn more</a></button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr class="my-5">';
                }
                } else {
                echo "No services found.";
                }
                
                ?>
        </div>
        <hr class="hrhr">
    </div>

    <!-- Featured Products -->
    <div class="container mt-5 values-section">
        <h2 class="text-center mb-5">Featured Products </h2>
        <div class="row">
            <?php
            $sql = "SELECT * FROM products LIMIT 3";
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
                    echo '<div class="col-md-4">';
                    echo '<div class="product logoss hidden">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="' . $name . '" class="product-image" data-toggle="modal" data-target="#img-modal-' . $name . '">';
                    echo '<h2>' . $name . '</h2>';
                    echo '<p>' . $description . '</p>';
                    echo '<div class="product-price">' . $price . '</div>';
                    echo '<button type="button" class="btn btn-primary seemore" data-toggle="modal" data-target="#product-modal-' . $name . '">See More</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // If there are no rows in the table, display a message
                echo "No products found.";
            }
            ?>
        </div>
    </div>

    <div class="darks">
        <!-- Values -->
        <div class="container mt-5 values-section">
            <h2 class="text-center mb-5 sec-title">Our Values</h2>
            <div class="row">
                <!-- Value 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center logoss hidden">
                        <div class="card-body">
                            <i class="fas fa-thumbs-up fa-4x mb-4 value-icon-2"></i>
                            <h5 class="card-title">Customer Satisfaction</h5>
                            <p class="card-text">
                                WWe are committed to delivering the best possible experience
                                to our clients, and strive to exceed their expectations in
                                every way.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Value 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center logoss hidden">
                        <div class="card-body">
                            <i class="fas fa-tools fa-4x mb-4 value-icon-2"></i>
                            <h5 class="card-title">Quality Workmanship</h5>
                            <p class="card-text">
                                We take pride in our work and are committed to delivering the
                                highest level of quality in all that we do. From installation
                                to repair and maintenance, we strive for excellence in every
                                aspect of our work.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Value 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center logoss hidden">
                        <div class="card-body">
                            <i class="fas fa-shield-alt fa-4x mb-4 value-icon-2"></i>
                            <h5 class="card-title">Integrity</h5>
                            <p class="card-text">
                                We believe that honesty and integrity are the foundation of
                                any successful business relationship. We are committed to
                                conducting ourselves with the highest level of professionalism
                                and transparency in all that we do.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Footer -->
    <?php include_once('../homeIncludes/footer.php');?>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="../js/particles.js"></script>
    <script src="../js/app.js"></script>


    <script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            console.log(entry)
            if (entry.isIntersecting) {
                entry.target.classList.add('shows');
            } else {
                entry.target.classList.remove('shows');
            }
        });
    });

    const hiddenElements = document.querySelectorAll('.hidden');
    hiddenElements.forEach((el) => observer.observe(el));
    </script>
</body>

</html>
