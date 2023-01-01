<?php

require_once 'tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = 'actives';
include_once('homeIncludes/header.php');


?>


<body>
  <?php include_once('homeIncludes/homenav.php');?>

  <div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-inner carousel-inners">
      <div class="carousel-item active">
        <img src="img/cctv.jpg" class="d-block w-100" alt="..." />
        <div class="carousel-caption">
          <h5>Smart Security Solutions</h5>
          <p>
            We offer a wide range of repair for most types of electronics and
            Job orders like CCTV installation. Simply fill out our online form
            to request a repair or Job order and one of our technicians will
            be in touch with you soon.
          </p>
          <div class="req">
            <p>
              <a class="btn btn-outline-success log1" role="submit" href="#">Job Order</a>
            </p>
            <p>
              <a class="btn btn-outline-success log2" role="submit" href="#">Repair Request</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="darks">
    <!-- Values -->
    <div class="container mt-5 values-section">
      <h2 class="text-center mb-5 sec-title">Our Values</h2>
      <div class="row">
        <!-- Value 1 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 text-center">
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
          <div class="card h-100 text-center">
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
          <div class="card h-100 text-center">
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


    <!-- Reviews -->
    <div class="container mt-5">
      <h2 class="text-center mb-5 sec-title">Customer Reviews</h2>
      <div class="row">
        <!-- Review 1 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <!-- Rating -->
              <div class="mb-3">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <!-- Review -->
              <p class="card-text">
                "I highly recommend this product! It has completely
                transformed my business."
              </p>
              <!-- Author -->
              <p class="font-weight-bold">- Customer 1</p>
            </div>
          </div>
        </div>
        <!-- Review 2 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <!-- Rating -->
              <div class="mb-3">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
              </div>
              <!-- Review -->
              <p class="card-text">
                "I've tried several similar products, but this one is by far
                the best. The support team is also top-notch."
              </p>
              <!-- Author -->
              <p class="font-weight-bold">- Customer 2</p>
            </div>
          </div>
        </div>
        <!-- Review 3 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <!-- Rating -->
              <div class="mb-3">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
              <!-- Review -->
              <p class="card-text">
                "I'm so happy with the results I've seen since using this
                product. It's exceeded my expectations."
              </p>
              <!-- Author -->
              <p class="font-weight-bold">- Customer 3</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Featured Products -->

  <div class="container mt-5 con-prod">
    <div class="center">
      <div class="text-center mb-5">
        <b class="title-line">&nbsp;</b>
        <h2 class="d-inline-block title-text">Featured Products</h2>
        <b class="title-line">&nbsp;</b>
      </div>
      <div class="row">
        <!-- Product 1 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="img/prod1.jpg" class="card-img-top" alt="Product 1" />
            <div class="card-body">
              <h5 class="card-title">VIGI C300HP</h5>
              <p class="card-text">
                VIGI 3MP Outdoor Bullet Network Camera
              </p>
              <a href="#" class="btn btn-primary stretched-link lm">Learn More</a>
            </div>
          </div>
        </div>
        <!-- Product 2 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="img/prod2.jpg" class="card-img-top" alt="Product 2" />
            <div class="card-body">
              <h5 class="card-title">VIGI C300HP</h5>
              <p class="card-text">
                VIGI 3MP Outdoor Bullet Network Camera
              </p>
              <a href="#" class="btn btn-primary stretched-link lm">Learn More</a>
            </div>
          </div>
        </div>
        <!-- Product 3 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="img/prod3.jpg" class="card-img-top" alt="Product 3" />
            <div class="card-body">
              <h5 class="card-title">VIGI NVR1016H</h5>
              <p class="card-text">
                VIGI 16 Channel Network Video Recorder
              </p>
              <a href="#" class="btn btn-primary stretched-link lm">Learn More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once('homeIncludes/footer.php');?>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>