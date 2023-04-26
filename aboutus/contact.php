<?php
session_start();
require_once '../tools/variables.php';
include_once('../homeIncludes/header.php');
require_once '../homeIncludes/dbconfig.php';
$page_title = 'ProtonTech | About Us';
$contact = 'actives';
?>

<body class="view-body">
    <?php include_once('../homeIncludes/homenav.php');?>

    <div class="about-section">
        <div class="container container-contact">
            <div class="row row-contact">
            <div class="col-md-7 colcontact">
              <h4>Get in touch</h4>
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input type="text" class="form-control form-control-contact" id="formGroupExampleInput" placeholder="Enter your name">
                  </div>
                  <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Email</label>
                    <input type="text" class="form-control form-control-contact" id="formGroupExampleInput2" placeholder="Enter your email">
                  </div>
                  <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Contact Number</label>
                    <input type="text" class="form-control form-control-contact" id="formGroupExampleInput2" placeholder="Enter your number">
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                    <textarea class="form-control form-control-contact" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>
                  <button class="btn-contact">Submit</button>
            </div>
            <div class="col-md-5 colcontacts">
              <h4>Contact us</h4><hr>
              <div class="mt-4">
                  <div class="d-flex">
                    <i class="bi bi-geo-alt-fill"></i>
                    <p >Address: Aguinaldo, Lamitan City</p>
                  </div><hr>
                  <div class="d-flex">
                    <i class="bi bi-browser-chrome"></i>
                    <p>Service Area: Isabela, Philippines · Lamitan, Philippines</p>
                  </div><hr>
                  <div class="d-flex">
                    <i class="bi bi-telephone-fill"></i>
                    <p>Mobile : 0935 223 2051</p>
                  </div><hr>
                  <!-- <div class="d-flex"> -->
                    <!-- <i class="bi bi-envelope-fill"></i> -->
                    <!-- <p>Email:- Contact@gmail.com</p> -->
                  <!-- </div><hr> -->
              </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('../homeIncludes/footer.php');?>

</body>

</html>