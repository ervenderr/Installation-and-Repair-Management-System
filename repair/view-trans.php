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


$transaction_code = $_SESSION['transaction_code'];
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
rp_timeline.*,
elec_brand.*,
defects.*,
customer.*
FROM rprq
LEFT JOIN technician ON rprq.tech_id = technician.tech_id
LEFT JOIN rp_timeline ON rprq.id = rp_timeline.rprq_id
LEFT JOIN elec_brand ON rprq.eb_id = elec_brand.eb_id
LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
LEFT JOIN defects ON rprq.defect_id = defects.defect_id
LEFT JOIN customer ON rprq.cust_id = customer.cust_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
WHERE accounts.account_id = '{$user_id}'
ORDER BY rp_timeline.tm_date DESC, rp_timeline.tm_time DESC;";
$result = mysqli_query($conn, $query);


                  if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                  }

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

                <div class="col-sm-3 sidebar cust-side">
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
                    <div class="ticket">
                        <div class="ticket-header">
                            <span class="text">Proton</span><span class="green">Tech</span></a>
                            <p>Confirmation Ticket</p>
                        </div>

                        <div class="ticket-body">
                            <div>
                                <p class="nopad">Transaction Code:</p>
                                <p><?php echo $row['transaction_code']?></p>
                            </div>
                            <div>
                                <p class="nopad">Customer Name:</p>
                                <p><?php echo $row['fname'] ." " .  $row['lname']?></p>
                            </div>
                            <div>
                                <p class="nopad">Date:</p>
                                <p><?php echo $row['date_req']?></p>
                            </div>
                        </div>

                        <div class="ticket-footer"></div>
                    </div>
                </div>
                <div class="col-sm-9 accform ">
                    <div class="tracking-list view-nav">
                        <div class="row">
                            <?php
                            $href = '';
                            if($row['rprq_status'] == 'Pending'){
                                $href = 'pending-transaction.php';
                            }
                            ?>
                            <div class="col-6"><a href="<?php echo $href ?>"><i class="fas fa-chevron-left"></i>
                                    Back</a></div>
                            <div class="col-6 nav-cont">
                                <span>REQUEST ID: <?php echo $row['transaction_code']?></span>
                                <span class="half">|</span>
                                <span class="stats">REQUEST <?php echo $row['rprq_status']?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div id="tracking">
                                <div class="tracking-list">
                                    <?php
                                    $content ='';
                                    if($row['rprq_status'] == 'Pending'){
                                        $content ='Repair request received';
                                    }elseif($row['rprq_status'] == 'In-progress'){
                                        $content ='The repair request has been assigned to a technician, and they are currently working on the repair';
                                    }elseif($row['rprq_status'] == 'Awaiting Parts'){
                                        $content ='The repair is on hold because the necessary parts are not available';
                                    }elseif($row['rprq_status'] == 'Awaiting Payment'){
                                        $content ='The technician has completed the evaluation, and the customer needs to pay a partial or full amount before the repair can proceed';
                                    }elseif($row['rprq_status'] == 'Repairing'){
                                        $content ='Partial payment has been received, the technician is working on the repair';
                                    }
                                    elseif($row['rprq_status'] == 'To pickup'){
                                        $content ='The repair is completed, your request is ready for picked up or delivered';
                                    }
                                    elseif($row['rprq_status'] == 'Completed'){
                                        $content ='Picked up / Delivered';
                                    }
                                    
                                    $result2 = mysqli_query($conn, $query);
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $status = $row2['tm_status'];
                                        $date = $row2['tm_date'];
                                        $time = $row2['tm_time'];
                                        $location = $row2['tm_location'];
                                        $isCurrentStatus = $row2['tm_status'];
                                        $statusClass = $isCurrentStatus ? 'status-intransit' : 'status-delivered';
                                    ?>
                                    <div class="tracking-item">
                                        <div class="tracking-icon <?php echo $statusClass; ?>">
                                        </div>
                                        <div class="tracking-date">
                                            <?php echo $date; ?><span><?php echo $time; ?></span>
                                        </div>
                                        <div class="tracking-content">
                                            <?php echo $status; ?><span><?php echo $content; ?></span>
                                        </div>
                                    </div>
                                    <?php
                }
                ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap pending-card viewpnd">
                        <?php
                        ?>
                        <div class="card mb-3 transaction-details-card view-dtls">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Electronic
                                                Type:</span>
                                            <span><?php echo $row['elec_name']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Brand:</span>
                                            <span class=""><?php echo $row['eb_name'] ?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Defects:</span>
                                            <span
                                                class="transaction-details-none"><?php echo $row['defect_name']?></span>
                                        </div>
                                        <div class="text-start">
                                            <form method="post" action="../repair-invoice/booking-repair-pdf.php"
                                                target="_blank">
                                                <?php
                                            $_SESSION['rp_id'] = $row['id'];
                                            ?>
                                                <button type="submit" name="download" value="<?php echo $row['id']; ?>"
                                                    class="btn btn-secondary">Download
                                                    Ticket <i class="fas fa-download"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Shipping:</span>
                                            <span
                                                class="transaction-details-standard-shipping"><?php echo $row['shipping']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Date
                                                Requested:</span>
                                            <span><?php echo $row['date_req']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Expected
                                                Completion:</span>
                                            <span class="tbh"><i class="fas fa-exclamation-circle"></i>
                                                <?php
                                                    if($row['date_completed'] == '0000-00-00'){
                                                        echo 'TBA';
                                                    }else{
                                                        echo $row['date_completed'];
                                                    }
                                                    ?>
                                            </span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Assigned
                                                Technician:</span>
                                            <span class="tbh"><i class="fas fa-exclamation-circle"></i>
                                                <?php
                                                    if($row['tech_id'] == ''){
                                                        echo 'TBA';
                                                    }else{
                                                        echo $row['date_completed'];
                                                    }
                                                    ?>
                                            </span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Technician's
                                                Contact:</span>
                                            <span class="tbh"><i class="fas fa-exclamation-circle"></i>
                                                <?php
                                                    if($row['tech_phone'] == ''){
                                                        echo 'TBA';
                                                    }else{
                                                        echo $row['tech_phone'];
                                                    }
                                                    ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <tr class="text-end">
                                            <th class="">Labor Cost:</th>
                                            <td></td>
                                        </tr>
                                        <tr class="text-end">
                                            <th>Part Cost:</th>
                                            <td></td>
                                        </tr>
                                        <tr class="text-end">
                                            <th>Repair Request Total:</th>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            </table>
                        </div>
                    </div>



                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js">
                    </script>
                    <script>
                    document.getElementById("download").addEventListener("click", function() {
                        const ticket = document.querySelector(".ticket");
                        html2canvas(ticket).then(function(canvas) {
                            const element = document.createElement("a");
                            element.setAttribute("href", canvas.toDataURL("image/png").replace(
                                "image/png",
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