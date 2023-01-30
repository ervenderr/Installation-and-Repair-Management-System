<?php
require_once 'homeIncludes/dbconfig.php';
require_once 'tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
$servpkgnav = 'servactives';
include_once('homeIncludes/header.php');



?>

<body>
    <?php
    include_once('homeIncludes/homenav.php');
    ?>

    <div class="jobcon">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link <?php echo $servpkgnav; ?>" aria-current="page" href="servpkg">Packages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $servreqnav; ?>" href="servreq.php">Service Request</a>
            </li>
            </li>
        </ul>
        <div class="container">


                <?php
            $sql = "SELECT * FROM package";
            $result = mysqli_query($conn, $sql);

            // Check if there are any rows in the table
            if (mysqli_num_rows($result) > 0) {
                // If there are rows, output the name, price, description, and image for each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $service = $row['service_id'];
                    $name = $row['name'];
                    $price = $row['price'];
                    $description = $row['descriptions'];
                    $image = $row['image'];

                    // Output the product information
                    if($service == 1){
                        echo '<div class="pcon">';
                        echo '<h4 class="pkgheadtext">CCTV packages</h4>';
                        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">';
                        echo '<div class="col pr">';
                        echo '<div class="card pkgcard">';
                        echo '<div class="img-wrapper"><img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="' . $name . '" class="d-block w-100" alt="..."> </div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $name . '</h5>';
                        echo '<p class="card-text">₱ ' . $price . '</p>';
                        echo '<p class="card-text">' . $description . '</p>';
                        echo '<a href="servreq.php" class="btn btn-primary pkgbtn">Avail now</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="ftext">';
                        echo '<div class="">';
                        echo '<h6 class="pkgtext">Service Offered:</h6>';
                        echo '<p class="ptext">Service Offered:</p>';
                        echo '</div>';
                        echo '<div class="">';
                        echo '<h6 class="pkgtext">Add Ons:</h6>';
                        echo '<p class="ptext">Service Offered</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="pcon">';
                        echo '<h4 class="pkgheadtext">CCTV packages</h4>';
                        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">';
                        echo '<div class="col pr">';
                        echo '<div class="card pkgcard">';
                        echo '<div class="img-wrapper"><img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="' . $name . '" class="d-block w-100" alt="..."> </div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $name . '</h5>';
                        echo '<p class="card-text">₱ ' . $price . '</p>';
                        echo '<p class="card-text">' . $description . '</p>';
                        echo '<a href="servreq.php" class="btn btn-primary pkgbtn">Avail now</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="ftext">';
                        echo '<h6 class="pkgtext">Service Offered</h6>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            } else {
                // If there are no rows in the table, display a message
                echo "No products found.";
            }

            ?>
            </div>
            <br>
            <br>

        </div>










        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        var multipleCardCarousel = document.querySelector(
            "#cctvpkg"
        );
        if (window.matchMedia("(min-width: 768px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#cctvpkg .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 4) {
                    scrollPosition += cardWidth;
                    $("#cctvpkg .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                }
            });
            $("#cctvpkg .carousel-control-prev").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                    $("#cctvpkg .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                }
            });
        } else {
            $(multipleCardCarousel).addClass("slide");
        }
        </script>

</body>

</html>