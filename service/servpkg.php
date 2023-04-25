<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
$servpkgnav = 'servactives';
include_once('../homeIncludes/header.php');



?>

<body>
    <?php
    include_once('../homeIncludes/homenav.php');
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
            <section class="section-products">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="header">
                                <h2>Packages</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
            $sql = "SELECT * FROM package";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $service = $row['service_id'];
                    $name = $row['name'];
                    $price = $row['price'];
                    $image = $row['image'];

                    if ($service == 1) {
                        echo '<div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="view-packge.php?rowid='. $row['pkg_id'] .'">
                            <div class="card">
                                <div id="product-1" class="single-product p-2">
                                    <div class="part-1">
                                        <img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="'.$name.'" class="d-block w-100 h-100">
                                        <ul>
                                        <a href="view-packge.php?rowid='. $row['pkg_id'] .'" class="btn btn-primary pkgbtn">View Detais</a>
                                        <a href="view-packge.php?rowid='. $row['pkg_id'] .'" class="btn btn-primary pkgbtn">Avail Now</a>
                                        </ul>
                                    </div>
                                    <div class="part-2 p-2">
                                        <h3 class="product-title">'.$name.'</h3>
                                        <h4 class="product-price">₱'.$price.'</h4>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>';
                    }
                }
            } else {
                // If there are no rows in the table, display a message
                echo "No products found.";
            }
            ?>
                    </div>
                </div>
            </section>

        </div>
    </div>










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