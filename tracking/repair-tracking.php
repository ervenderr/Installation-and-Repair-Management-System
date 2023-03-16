<?php
session_start();

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Tracking';
include_once('../homeIncludes/header.php');

if (!isset($_GET['search'])){
    header('location: ../tracking/tracking.php');
}

if (isset($_GET['search'])) {
    $transaction_number = $_GET['search'];

    $query = "SELECT * FROM rprq 
    INNER JOIN customer ON rprq.cust_id = customer.cust_id
    INNER JOIN accounts ON customer.account_id = accounts.account_id
    WHERE transaction_code = ? LIMIT 1";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $transaction_number);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "No Transaction Found";
        header('location: ../tracking/tracking.php');
        exit;
    }

    $row = mysqli_fetch_assoc($result);
}


?>

<body class="track">
    <?php include_once('../homeIncludes/homenav.php');?>
    <img src="../img/rp2.jpg" alt="repair-bg" class="bg-search">

    <div class="container tracking-container">
        <div class="card">
            <div class="row d-flex justify-content-between px-3 top">
                <div class="d-flex flex-column col-sm col-md ml-auto">
                    <h5>Transaction number:</h5>
                    <span class="text-primary font-weight-bold"><?php echo $transaction_number; ?></span>
                </div>
                <div class="d-flex flex-column col-sm col-md flxend">
                    <p class="mb-0">Expected Completion: <span><?php echo $row['date_completed']; ?></span></p>
                    <?php
                    $statusBg = "";
                    $Inprogress = "";
                    $done = "";
                    $completed = "";
                    if($row['status'] == 'In-progress'){
                        $statusBg = "bg-info";
                        $Inprogress = "active";
                    }elseif($row['status'] == 'Pending'){
                        $statusBg = "bg-warning";
                    }elseif($row['status'] == 'Done'){
                        $statusBg = "bg-primary";
                        $Inprogress = "active";
                        $done = "active";
                    }elseif($row['status'] == 'Completed'){
                        $statusBg = "bg-success";
                        $Inprogress = "active";
                        $done = "active";
                        $completed = "active";
                    }
                    
                    ?>
                    <p>Status: <span class="font-weight-bold text-white statusBg <?php echo $statusBg; ?>"><?php echo $row['status']; ?></span></p>
                </div>
            </div>

            <!-- Add class 'active' to progress -->
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        <li class="active step0"><br><span>Pending</span></li>
                        <li class="<?php echo $Inprogress; ?> step0"><br><span>Repairing</span></li>
                        <li class="<?php echo $done; ?> step0"><br><span>To pickup</span></li>
                        <li class="<?php echo $completed; ?> step0"><br><span>Completed</span></li>
                    </ul>
                </div>
            </div>

            <div class="row details-req ">
                <div class="width-auto">
                    <h6 class="font-weight-bold">Customer Information</h6>
                    <p><strong>Name:</strong> <?php echo $row['fname'] ." ". $row['lname']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                    <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                </div>
                <div class="width-auto">
                    <h6 class="font-weight-bold">Electronic Information</h6>
                    <p><strong>Electronic Type:</strong> <?php echo $row['etype']; ?></p>
                    <p><strong>Defects:</strong> <?php echo $row['defective']; ?></p>
                    <p><strong>Shipping:</strong> <?php echo $row['shipping']; ?></p>
                    <p><strong>Date Requested:</strong> <?php echo $row['date_req']; ?></p>
                    
                </div>
                <?php
                    if (!empty($row['invoice_id'])) {
                    $invoice_id = $row['invoice_id'];
                    echo '<a href="../repair-invoice/print.php?invoice_id=' . $invoice_id .'" target="_blank" class="btn btn-secondary btn-fw ">
                    Download Invoice <i class="fas fa-download"></i></a>';
                    }

                    if (($row['invoice_id'] == 0) && ($row['status'] == 'Pending')) {
                        echo '<div class="text-center">
                        <form method="post" action="../repair-invoice/booking-repair-pdf.php"
                            target="_blank">
                            <button type="submit" name="download" value="'.$row['id'].'" class="btn btn-info text-white">Download Ticket <i class="fas fa-download"></i></button>
                        </form>
                    </div>';
                    }
                ?>

            </div>
        </div>
    </div>

</body>

</html>