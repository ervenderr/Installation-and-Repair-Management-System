<nav class="navbar navbar-expand-lg bg-body-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Offcanvas navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $home; ?>" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $services; ?>" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $products; ?>" href="products.php">Products</a>
                </li>
                <li class="nav-item dropdown noborder">
                    <a class="nav-link dropdown-toggle mrq" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Make a request
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="mrq <?php echo $job; ?>" href="servpkg.php">Service Order</a></li>
                        <li><a class="mrq <?php echo $repair; ?>" href="repair.php">Repair Request</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $about; ?>" href="about.php">about</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $contact; ?>" href="contact.php">contact</a>
                </li>
            </ul>
            <div class="track"><a href="">Request status <i class="fa fa-search"></i></a></div>
      </div>
    </div>
  </div>
</nav>