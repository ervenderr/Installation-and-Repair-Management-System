<?php

require_once 'tools/variables.php';
$page_title = 'ProtonTech | Products';
$products = 'actives';
include_once('homeIncludes/header.php');


?>

<body>
    <?php include_once('homeIncludes/homenav.php'); ?>


    <div class="container servicecon">
        <h2 class="text-center mb-5">PRODUCTS</h2>

        <form class="form-inline">
            <div class="form-group my-2 sort">
                <label for="sort-select">Sort by:</label>
                <select class="form-control" id="sort-select" onchange="sort()">
                    <option value="price-asc">Price (low to high)</option>
                    <option value="price-desc">Price (high to low)</option>
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                </select>
            </div>

            <div class="form-group my-2 searchform">
                <div class="input-group">
                    <input type="text" class="form-control" id="search-input" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-primary seemore magni" type="button" onclick="search()"><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>


        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-4">
                <div class="product">
                    <img src="img/prod1.jpg" alt="Product 1" class="product-image">
                    <h2>Product 1</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla
                        finibus lobortis pulvinar.</p>
                    <div class="product-price">$99.99</div>
                    <button type="button" class="btn btn-primary seemore" data-toggle="modal"
                        data-target="#product-1-modal">See More</button>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="col-md-4">
                <div class="product">
                    <img src="img/prod2.jpg" alt="Product 2" class="product-image">
                    <h2>Product 2</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla
                        finibus lobortis pulvinar.</p>
                    <div class="product-price">$129.99</div>
                    <button type="button" class="btn btn-primary seemore" data-toggle="modal"
                        data-target="#product-2-modal">See More</button>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-md-4">
                <div class="product">
                    <img src="img/prod3.jpg" alt="Product 3" class="product-image">
                    <h2>Product 3</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla
                        finibus lobortis pulvinar.</p>
                    <div class="product-price">$149.99</div>
                    <button type="button" class="btn btn-primary seemore" data-toggle="modal"
                        data-target="#product-3-modal">See More</button>
                </div>
            </div>
        </div>


        <?php include_once('modals/product_modal.php'); ?>

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
  <?php include_once('homeIncludes/footer.php');?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>