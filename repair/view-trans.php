<?php
session_start();
error_reporting(0);
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
defects.*,
customer.*
FROM rprq
LEFT JOIN technician ON rprq.tech_id = technician.tech_id
LEFT JOIN electronics ON rprq.elec_id = electronics.elec_id
LEFT JOIN defects ON rprq.defect_id = defects.defect_id
LEFT JOIN customer ON rprq.cust_id = customer.cust_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
WHERE accounts.account_id = '{$user_id}';";
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
                            <div class="col-6"><i class="fas fa-chevron-left"></i> Back</div>
                            <div class="col-6 nav-cont">
                                <span>REQUEST ID: <?php echo $row['transaction_code']?></span>
                                <span class="half">|</span>
                                <span class="stats">REQUEST <?php echo $row['rprq_status']?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div id="tracking-pre"></div>
                            <div id="tracking">
                                <div class="tracking-list">
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-intransit">
                                            <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                                data-prefix="fas" data-icon="circle" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                                </path>
                                            </svg>
                                            <!-- <i class="fas fa-circle"></i> -->
                                        </div>
                                        <div class="tracking-date">Jul 09, 2018<span>11:04 AM</span></div>
                                        <div class="tracking-content">Pickup shipment checked in at
                                            SHENZHEN.<span>SHENZHEN, CHINA, PEOPLE'S REPUBLIC</span></div>
                                    </div>
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-intransit">
                                            <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true"
                                                data-prefix="fas" data-icon="circle" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z">
                                                </path>
                                            </svg>
                                            <!-- <i class="fas fa-circle"></i> -->
                                        </div>
                                        <div class="tracking-date">Jul 09, 2018<span>10:09 AM</span></div>
                                        <div class="tracking-content">Shipment info registered at
                                            SHENZHEN.<span>SHENZHEN, CHINA, PEOPLE'S REPUBLIC</span></div>
                                    </div>
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-inforeceived">
                                            <svg class="svg-inline--fa fa-clipboard-list fa-w-12" aria-hidden="true"
                                                data-prefix="fas" data-icon="clipboard-list" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M336 64h-80c0-35.3-28.7-64-64-64s-64 28.7-64 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM96 424c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm0-96c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm0-96c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24-10.7 24-24 24zm96-192c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm128 368c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-96c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-96c0 4.4-3.6 8-8 8H168c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16z">
                                                </path>
                                            </svg>
                                            <!-- <i class="fas fa-clipboard-list"></i> -->
                                        </div>
                                        <div class="tracking-date">Jul 06, 2018<span>02:02 PM</span></div>
                                        <div class="tracking-content">Shipment designated to MALAYSIA.<span>HONG KONG,
                                                HONGKONG</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap pending-card viewpnd">
                        <?php
                        $estimatedCost = $row['def_cost'] + $row['elec_cost'];
                        ?>
                        <div class="card mb-3 transaction-details-card view-dtls">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Electronic Type:</span>
                                            <span><?php echo $row['elec_name']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Defects:</span>
                                            <span class="transaction-details-none"><?php
                                                        if (empty($row['defect_id']) || $row['defect_id'] == 0) {
                                                            echo $row['other_defects'];
                                                        } else {
                                                            echo $row['defect_name'];
                                                        }
                                                        ?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Warranty:</span>
                                            <span class="">3 months</span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Shipping:</span>
                                            <span
                                                class="transaction-details-standard-shipping"><?php echo $row['shipping']?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Date Requested:</span>
                                            <span><?php echo $row['date_req']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Estimated
                                                Completion:</span>
                                            <span><?php echo $row['date_completed']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Assigned
                                                Technician:</span>
                                            <span><?php echo $row['tech_fname'] . " " . $row['tech_lname']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Technician's
                                                Contact:</span>
                                            <span><?php echo $row['tech_phone']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Remarks:</span>
                                            <textarea class="form-control" rows="3"
                                                readonly><?php echo $row['remarks']?></textarea>
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