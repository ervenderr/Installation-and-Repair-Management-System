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
                    <a class="nav-link <?php echo $home; ?>" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $services; ?>" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $products; ?>" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $job; ?>" href="#">Job Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $repair; ?>" href="#">Repair Request</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex log" role="search">
                <a class="btn btn-outline-success log1" role="submit" href="#">Log In</a>
                <a class="btn btn-outline-success log2" role="submit" href="#">Sign Up</a>
            </form>
        </div>
    </div>
</nav>