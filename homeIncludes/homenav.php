<nav class="navbar navbar-expand-lg bg-body-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <span class="text">Pr<img src="img/prot5.jpg" alt="" class="logo" />ton</span><span>Tech</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                        <li><a class="mrq <?php echo $job; ?>" href="jobs.php">Job Order</a></li>
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
</nav>
