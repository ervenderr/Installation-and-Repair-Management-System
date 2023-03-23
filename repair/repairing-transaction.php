<?php
session_start();
if (!isset($_SESSION['logged_id'])) {
    header('location: ../login/login.php');
}

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = '';
$repairtransac = 'account-active';
include_once('../homeIncludes/header.php');


$user_id = $_SESSION['logged_id'];

$query = "SELECT * 
FROM customer 
LEFT JOIN accounts ON customer.account_id=accounts.account_id 
LEFT JOIN rprq 
ON rprq.cust_id=customer.cust_id 
WHERE accounts.account_id='{$user_id}'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);




?>

<body>
    <?php include_once('../homeIncludes/homenav.php');?>

    <div class="accountcon">
        <div class="container-fluid">
            <div class="accheader">
                <h4>My Transactions</h4>
            </div>
            <div class="row">

                <div class="col-sm-3 sidebar">
                    <div class="accon d-flex align-items-center">
                        <img src="../img/usericon.png" alt="user icon" class="user-icon">
                        <h5 class="mb-0"><?php echo $row['fname'] ." " .  $row['lname']?></h5>
                    </div>
                    <div class="rprq">
                        <a href="../repair/pending-transaction.php" class="<?php echo $repairtransac; ?>">Repair
                            request</a>
                    </div>
                    <div>
                        <a href="../service/pending-transaction.php" class="<?php echo $servicetransac; ?>">Service
                            request</a>
                    </div>
                    <div>
                        <a href="../mytransactions/account.php" class="<?php echo $accsetting; ?>">Account setting</a>
                    </div>
                    <div>
                        <a href="../login/logout.php">Logout</a>
                    </div>
                    <?php
                    // Get the counts for each status
                    $query_pending = "SELECT * FROM rprq 
                    LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                    LEFT JOIN accounts ON customer.account_id = accounts.account_id
                    WHERE status='Pending' AND accounts.account_id = '{$user_id}';";
                    $result_pending = mysqli_query($conn, $query_pending);
                    $num_pending = mysqli_num_rows($result_pending);

                    $query_in_progress = "SELECT * FROM rprq 
                    LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                    LEFT JOIN accounts ON customer.account_id = accounts.account_id
                    WHERE status='In-progress' AND accounts.account_id = '{$user_id}';";
                    $result_in_progress = mysqli_query($conn, $query_in_progress);
                    $num_in_progress = mysqli_num_rows($result_in_progress);

                    $query_done = "SELECT * FROM rprq 
                    LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                    LEFT JOIN accounts ON customer.account_id = accounts.account_id
                    WHERE status='Done' AND accounts.account_id = '{$user_id}';";
                    $result_done = mysqli_query($conn, $query_done);
                    $num_done = mysqli_num_rows($result_done);

                    $query_completed = "SELECT * FROM rprq 
                    LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                    LEFT JOIN accounts ON customer.account_id = accounts.account_id
                    WHERE status='Completed' AND accounts.account_id = '{$user_id}';";
                    $result_completed = mysqli_query($conn, $query_completed);
                    $num_completed = mysqli_num_rows($result_completed);

                    // Set the notification count and style for each status
                    $notification_count_pending = $num_pending > 0 ? $num_pending : "";
                    $notification_style_pending = $num_pending > 0 ? "style='display: inline-block;'" : "";

                    $notification_count_in_progress = $num_in_progress > 0 ? $num_in_progress : "";
                    $notification_style_in_progress = $num_in_progress > 0 ? "style='display: inline-block;'" : "";

                    $notification_count_done = $num_done > 0 ? $num_done : "";
                    $notification_style_done = $num_done > 0 ? "style='display: inline-block;'" : "";

                    $notification_count_completed = $num_completed > 0 ? $num_completed : "";
                    $notification_style_completed = $num_completed > 0 ? "style='display: inline-block;'" : "";
                    ?>

                </div>
                <div class="col-sm-9 accform ">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page"
                                href="pending-transaction.php">Pending
                                <?php
                                if($notification_count_pending){
                                    echo'<span class="count-symbol bg-danger"></span>';
                                }
                                ?>
                            </a>
                        <a class="flex-sm-fill text-sm-center nav-link active" href="repairing-transaction.php">Repairing
                        <?php
                                if($notification_style_in_progress){
                                    echo'<span class="count-symbol bg-danger"></span>';
                                }
                                ?>
                        </a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="pickup-transaction.php">To pickup
                        <?php
                                if($notification_style_done){
                                    echo'<span class="count-symbol bg-danger"></span>';
                                }
                                ?>
                        </a>
                        <a class="flex-sm-fill text-sm-center nav-link" href="completed-transaction.php">Completed
                        <?php
                                if($notification_count_completed){
                                    echo'<span class="count-symbol bg-danger"></span>';
                                }
                                ?>
                        </a>
                    </nav>

                    <?php
                    $query2 = "SELECT rprq.*, 
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
                    defects.*,
                    customer.*
                    FROM rprq
                    LEFT JOIN technician ON rprq.tech_id = technician.tech_id
                    LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
                    LEFT JOIN defects ON rprq.defect_id = defects.defect_id
                    LEFT JOIN customer ON rprq.cust_id = customer.cust_id
                    LEFT JOIN accounts ON customer.account_id = accounts.account_id
                    WHERE rprq.status = 'In-Progress' AND accounts.account_id = '{$user_id}';";

                    $result2 = mysqli_query($conn, $query2);

                    if (mysqli_num_rows($result2) > 0) { ?>
                    <div class="d-flex flex-wrap pending-card">
                        <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                        <div class="card mb-3 transaction-details-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Transaction #:</span>
                                            <span class="text-primary"><?php echo $row2['transaction_code']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Status:</span>
                                            <span class="transaction-details-pending"><?php echo $row2['rprq_status']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Electronic Type:</span>
                                            <span><?php echo $row2['elec_name']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Defects:</span>
                                            <span class="transaction-details-none"><?php echo $row2['defect_name']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Initial Payment:</span>
                                            <span class="transaction-details-none"><?php echo $row2['initial_payment']?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Shipping:</span>
                                            <span
                                                class="transaction-details-standard-shipping"><?php echo $row2['shipping']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Date Requested:</span>
                                            <span><?php echo $row2['date_req']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Expected Completion:</span>
                                            <span><?php echo $row2['date_completed']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Assigned Technician:</span>
                                            <span><?php echo $row2['tech_fname'] . " " . $row2['tech_lname']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Technician's Contact:</span>
                                            <span><?php echo $row2['tech_phone']?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <?php } ?>
                    </div>

                    </table>
                    <?php } else { ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-exclamation-circle"></i> No Transaction at the moment.
                    </div>
                    <?php } ?>


                </div>
            </div>

        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
        <script>
        document.getElementById("download").addEventListener("click", function() {
            const ticket = document.querySelector(".ticket");
            html2canvas(ticket).then(function(canvas) {
                const element = document.createElement("a");
                element.setAttribute("href", canvas.toDataURL("image/png").replace("image/png",
                    "image/octet-stream"));
                element.setAttribute("download", "ticket.png");
                element.style.display = "none";
                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
            });
        });
        </script>

</body>

</html>