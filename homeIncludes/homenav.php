<nav class="navbar navbar-expand-lg bg-body-light fixed-top navs">
    <div class="container-fluid con-navs">
        <a class="navbar-brand" href="#">
            <span class="text">Pr<img src="../img/proton-logo.png" alt="" class="logo" />ton</span><span>Tech</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasNavbarLabel"><span class="text">Pr<img
                            src="../img/proton-logo.png" alt="" class="logos" />ton</span><span>Tech</span></a></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-links <?php echo $home; ?>" aria-current="page"
                            href="../homepage/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-links <?php echo $services; ?>"
                            href="../service/services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-links <?php echo $products; ?>"
                            href="../products/products.php">Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mrq" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Make a request
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="requestDropdown">
                            <li>
                                <a class="dropdown-item <?php echo $repair; ?>" href="../repair/repair.php">
                                    <i class="fas fa-tools me-2"></i> Repair Request
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $job; ?>" href="../service/servpkg.php">
                                    <i class="fas fa-cogs me-2"></i> Service Packages
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $job; ?>" href="../tracking/tracking.php">
                                    <i class="fas fa-search me-2"></i></i></i> Track your request
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-links <?php echo $about; ?>" href="../aboutus/about.php">about</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-links <?php echo $contact; ?>" href="../aboutus/contact.php"
                            data-toggle="modal" data-target="#modalContactForm">contact</a>
                    </li>
                </ul>
                <?php
                    if (!isset($_SESSION['logged_id']) && !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'customer') {
                        echo '<ul class="nav-item signinup">
                                            <li><a href="../login/login.php" class="nav-link nav-links signin" type="button">sign in</a></li>
                                            <li><a href="../login/signup.php" class="nav-link nav-links signup" type="button">Sign up</a></li>
                                        </ul>';
                    } else {
                        $user_id = $_SESSION['logged_id'];
                        $query = "SELECT rprq.*, 
technician.fname AS tech_fname, 
technician.lname AS tech_lname, 
technician.phone AS tech_phone,
technician.status AS tech_status, 
customer.fname AS cust_fname, 
customer.lname AS cust_lname, 
customer.phone AS cust_phone,
rprq.status AS rprq_status, 
accounts.*,
technician.*,
electronics.*,
rp_warranty.*,
elec_sub_categ.*,
rp_timeline.*,
elec_brand.*,
defects.*,
customer.*
FROM rprq
LEFT JOIN technician ON rprq.tech_id = technician.tech_id
LEFT JOIN rp_timeline ON rprq.id = rp_timeline.rprq_id
LEFT JOIN elec_brand ON rprq.eb_id = elec_brand.eb_id
LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
LEFT JOIN rp_warranty ON rprq.id = rp_warranty.rpwarranty_id
LEFT JOIN defects ON rprq.defect_id = defects.defect_id
LEFT JOIN customer ON rprq.cust_id = customer.cust_id
LEFT JOIN elec_sub_categ ON rprq.subcateg_id = elec_sub_categ.elec_sub_categ_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
WHERE accounts.account_id = '{$user_id}'
ORDER BY rp_timeline.tm_date DESC, rp_timeline.tm_time DESC;";


$result2 = mysqli_query($conn, $query);
$row3 = mysqli_fetch_assoc($result2);

$rprq_id = $row3['id'];

$rps = "SELECT t1.*, t3.count
FROM rp_timeline t1
INNER JOIN (
    SELECT rprq_id, MAX(tm_time) AS latest_date
    FROM rp_timeline
    GROUP BY rprq_id
) t2 ON t1.rprq_id = t2.rprq_id AND t1.tm_time = t2.latest_date
LEFT JOIN (
    SELECT rprq_id, COUNT(*) AS count
    FROM rp_timeline
    WHERE is_read = 0
    GROUP BY rprq_id
) t3 ON t1.rprq_id = t3.rprq_id
WHERE t1.rprq_id = '$rprq_id';

";

$result4 = mysqli_query($conn, $rps);

echo '<div class="col-xs-2 pull-right">
    <div class="notification">
        <a class="" href="#" id="bellnotif" data-bs-toggle="dropdown"
        role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell bellss"></i>';
            $query = "SELECT COUNT(*) AS count FROM rprq WHERE id = '$rprq_id' AND rp_isread = 0";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            $notification_count = $data['count'];
            
            if ($notification_count > 0) :
            echo'<span id="notification-badge" class="badge rounded-pill badge-notification bg-danger">'.$notification_count.'</span>';
        endif;
        echo'</a>
        <ul class="notification-menu" style="max-height: 300px; overflow-y: auto;">
        
        <h5 class="pt-2">NOTIFICATIONS</h5>
        <hr>';
        while ($row2 = mysqli_fetch_assoc($result4)){
            $content = '';
                    if ($row2['tm_status'] == 'Pending') {
                        $content = 'Repair request received';
                    } elseif ($row2['tm_status'] == 'Diagnosing') {
                        $content = 'The repair request has been assigned to a technician, and they are currently diagnosing your request';
                    } elseif ($row2['tm_status'] == 'In-progress') {
                        $content = 'Waiting for initial payment';
                    } elseif ($row2['tm_status'] == 'For repair') {
                        $content = 'Technician is preparing to repair your request';
                    } elseif ($row2['tm_status'] == 'Done') {
                        $content = 'Request is done. Please pay your unpaid balance';
                    } elseif ($row2['tm_status'] == 'Repairing') {
                        $content = 'Currently working on the repair';
                    } elseif ($row2['tm_status'] == 'Awaiting Parts') {
                        $content = 'The repair is on hold because the necessary parts are not available';
                    } elseif ($row2['tm_status'] == 'Awaiting Initial Payment') {
                        $content = 'The technician has completed the evaluation, and the customer needs to pay a partial or full amount before the repair can proceed';
                    } elseif ($row2['tm_status'] == 'Repairing') {
                        $content = 'Partial payment has been received, and the technician is working on the repair';
                    } elseif ($row2['tm_status'] == 'To Pickup') {
                        $content = 'Your request is ready for pickup. Please pay your unpaid balance';
                    } elseif ($row2['tm_status'] == 'To Deliver') {
                        $content = 'Your request is ready for delivery. Please pay your unpaid balance';
                    } elseif ($row2['tm_status'] == 'Completed') {
                        $content = 'Repair Transaction Completed';
                    }

                    $date = $row2['tm_date'];
                    $time = date("h:i a", strtotime($row2['tm_time']));


            echo '<a href="#"><li>
            <div class="timedate"><span>Transaction #:</span><span>' . $row3['transaction_code'] . '</span></div>
                <h3>' . $row2["tm_status"] . '</h3>
                <p>' . $content . '</p>
                <div class="timedate"><span>' . $date . '</span><span>' . $time . '</span></div>
            </li></a>';
        }             
        echo '</ul>
    </div>
</div>
</div>
</div>';


                        
                                        
echo ' <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="accountDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="../img/usericon.png" alt="user icon" class="user-icon">
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                        <li>
                                        <a class="dropdown-item" href="../repair/pending-transaction.php">
                                        <i class="fas fa-sync-alt me-2"></i> My Transactions
                                        </a>
                                        </li>
                                        <li>
                                        <a class="dropdown-item" href="../mytransactions/account.php">
                                            <i class="fas fa-user-circle me-2"></i> Manage Account
                                        </a>
                                        </li>
                                            <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cog me-2"></i> Settings
                                            </a>
                                            </li>
                                            <li>
                                            <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                            <a class="dropdown-item" href="../login/logout.php">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </a>
                                            </li>
                                        </ul>
                                        </div>
                                        </div>';
                    }
                    ?>

            </div>
        </div>
    </div>
</nav>

<script>
$(document).ready(function() {
    var main = function() {
        $('.notification a').click(function() {
            $('.notification-menu').toggle();
        });

        $('.post .btn').click(function() {
            $(this).toggleClass('btn-like');
        });
    };
    $(document).ready(main);

    document.getElementById("bellnotif").addEventListener("click", function() {
        var notificationBadge = document.querySelector(".badge-notification");
        if (notificationBadge) {
            notificationBadge.remove();
        }
    });

});
</script>

<script>
    $(document).ready(function() {
        $("#bellnotif").click(function() {
            // Make AJAX request to mark notifications as read
            $.ajax({
                url: "../homeIncludes/mark_as_read.php",
                type: "POST",
                data: {
                    rprq_id: <?php echo $rprq_id; ?>
                },
                success: function(data) {
                    // Hide notification badge
                    $(".badge-notification").remove();
                }
            });
        });
    });
</script>

