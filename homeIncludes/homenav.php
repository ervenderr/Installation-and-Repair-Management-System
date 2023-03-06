

<nav class="navbar navbar-expand-lg bg-body-light fixed-top navs">
  <div class="container-fluid con-navs">
  <a class="navbar-brand" href="#">
            <span class="text">Pr<img src="../img/proton-logo.png" alt="" class="logo" />ton</span><span>Tech</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="offcanvasNavbarLabel"><span class="text">Pr<img src="../img/proton-logo.png" alt="" class="logos" />ton</span><span>Tech</span></a></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $home; ?>" aria-current="page" href="../homepage/home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $services; ?>" href="../service/services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $products; ?>" href="../products/products.php">Products</a>
                </li>
                <li class="nav-item dropdown noborder">
                    <a class="nav-link dropdown-toggle mrq" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Make a request
                    </a>
                    <ul class="dropdown-menu dropdown-menu-req">
                        <li><a class="mrq <?php echo $job; ?>" href="../service/servpkg.php">Service Order</a></li>
                        <li><a class="mrq <?php echo $repair; ?>" href="../repair/repair.php">Repair Request</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $about; ?>" href="about.php">about</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-links <?php echo $contact; ?>" href="" data-toggle="modal" data-target="#modalContactForm">contact</a>
                </li>
            </ul>
            <?php
                    if (!isset($_SESSION['logged_id']) && !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'customer') {
                        echo '<ul class="nav-item signinup">
                                            <li><a href="../login/login.php" class="nav-link nav-links signin" type="button">sign in</a></li>
                                            <li><a href="../login/signup.php" class="nav-link nav-links signup" type="button">Sign up</a></li>
                                        </ul>';
                    } else {
                        echo '<div class="btn-group accpc">
                                        <a type="button" class="bell" aria-expanded="false">
                                        <i class="far fa-bell"></i>
                                        </a>
                                        <a type="button" class="bell envelop" aria-expanded="false">
                                        <i class="far fa-envelope"></i>
                                        </a>
                                        <a type="button" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="../img/usericon.png" alt="user icon" class="user-icon">
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end dp-setting">
                                            <li><a class="dropdown-item" href="../mytransactions/account.php"><img src="../img/usericon.png" alt="user icon" class="user-icon user-iconn">Manage Account</a></li>
                                            <li class="logout-align"><a href="../repair/pending-transaction.php" class="dropdown-item" type="button"><i class="fas fa-sync"></i>My Transactions</a></li>
                                            <li class="logout-align"><a href="#" class="dropdown-item" type="button"><i class="fas fa-cog"></i>Setting</a></li>
                                            <li class="logout-align"><a href="../login/logout.php" class="dropdown-item" type="button"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                                        </ul>
                                    </div>';
                    }
                    ?>
        
      </div>
    </div>
  </div>
</nav>