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
        <div class="container" id="product-section">
            <div class="row">
                <div class="col-md-6">
                    … [this is the product image]
                </div>
                <div class="col-md-6">
                    …[this is the product information]
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
        <br>
        <br>

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