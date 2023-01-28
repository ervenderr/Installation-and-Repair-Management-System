<?php
require_once 'homeIncludes/dbconfig.php';
require_once 'tools/variables.php';
$page_title = 'ProtonTech | Repair Request';
$job = 'actives activess';
include_once('homeIncludes/header.php');



?>

<body>
    <?php
    include_once('homeIncludes/homenav.php');
    ?>

    <div class="jobcon">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            </li>
        </ul>
        <div class="container">
            <h4 class="pkgtext">CCTV packages</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                <div class="col pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <!-- Other -->

            <div class="row">
                <h4>Other packages</h4>
                <div class="col-sm-4 mb-3 mb-sm-0 pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 pr">
                    <div class="card">
                        <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.
                            </p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>

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