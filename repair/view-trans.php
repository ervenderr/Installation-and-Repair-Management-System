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


$transaction_code = $_SESSION['transaction_id'];
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
WHERE accounts.account_id = '{$user_id}' AND rprq.transaction_code = '{$transaction_code}'
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
                            }elseif($row['rprq_status'] == 'In-progress'){
                                $href = 'repairing-transaction.php';
                            }elseif($row['rprq_status'] == 'To Pickup' || $row['rprq_status'] == 'To Deliver'){
                                $href = 'pickup-transaction.php';
                            }elseif($row['rprq_status'] == 'Completed'){
                                $href = 'completed-transaction.php';
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
                $result2 = mysqli_query($conn, $query);
                $first = true;
                while ($row2 = mysqli_fetch_assoc($result2)) {

                    $content = '';
                    if ($row2['tm_status'] == 'Pending') {
                        $content = 'Repair request received';
                    } elseif ($row2['tm_status'] == 'Diagnosing') {
                        $content = 'The repair request has been assigned to a technician, and they are currently diagnosing your request';
                    } elseif ($row2['tm_status'] == 'In-progress') {
                        $content = 'Waiting for initial payment';
                    } elseif ($row2['tm_status'] == 'To repair') {
                        $content = 'Technician is preparing to repair your request';
                    } elseif ($row2['tm_status'] == 'Repairing') {
                        $content = 'Currently working on the repair';
                    } elseif ($row2['tm_status'] == 'Awaiting Parts') {
                        $content = 'The repair is on hold because the necessary parts are not available';
                    } elseif ($row2['tm_status'] == 'Awaiting Initial Payment') {
                        $content = 'The technician has completed the evaluation, and the customer needs to pay a partial or full amount before the repair can proceed';
                    } elseif ($row2['tm_status'] == 'Repairing') {
                        $content = 'Partial payment has been received, and the technician is working on the repair';
                    } elseif ($row2['tm_status'] == 'To Pickup') {
                        $content = 'Your request is ready for pickup';
                    } elseif ($row2['tm_status'] == 'To Deliver') {
                        $content = 'Your request is ready for delivery';
                    } elseif ($row2['tm_status'] == 'Completed') {
                        $content = 'Picked up / Delivered';
                    }

                    $status = $row2['tm_status'];
                    $date = $row2['tm_date'];
                    $time = $row2['tm_time'];
                    $location = $row2['tm_location'];
                    $isCurrentStatus = $row2['tm_status'];
                    $statusClass = $isCurrentStatus ? 'status-intransit' : 'status-delivered';
                    $latestClass = $first ? 'latest' : '';
            ?>
                    <div class="tracking-item <?php echo $isCurrentStatus ? 'current-status' : ''; ?> <?php echo $latestClass; ?>">
                        <?php if ($isCurrentStatus) { ?>
                            <div class="tracking-icon checked">
                                <span class="checkmark">&#10003;</span>
                            </div>
                        <?php } else { ?>
                            <div class="tracking-icon <?php echo $statusClass; ?>"></div>
                        <?php } ?>
                        <div class="tracking-date">
                            <?php echo $date; ?><span><?php echo $time; ?></span>
                        </div>
                        <div class="tracking-content">
                            <p class="status-text"><?php echo $status; ?></p>
                            <p class="status-content"><?php echo $content; ?></p>
                        </div>
                    </div>
            <?php
                    $first = false;
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
                                            <span class="fw-bold me-2 transaction-details-label">ESTIMATED
                                                Completion:</span>
                                            <?php
                                                    if($row['tech_id'] == ''){
                                                        echo '<span class="tbh"><i class="fas fa-exclamation-circle">TBA</i></span>';
                                                    }else{
                                                        echo $row['date_day']." day(s) ";
                                                    }
                                                    ?>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Assigned
                                                Technician:</span>
                                            <?php
                                                    if($row['tech_id'] == ''){
                                                        echo '<span class="tbh"><i class="fas fa-exclamation-circle">TBA</i></span>';
                                                    }else{
                                                        echo $row['tech_fname']." ".$row['tech_lname'];
                                                    }
                                                    ?>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Technician's
                                                Contact:</span>
                                            <?php
                                                    if($row['tech_id'] == ''){
                                                        echo '<span class="tbh"><i class="fas fa-exclamation-circle">TBA</i></span>';
                                                    }else{
                                                        echo $row['tech_phone'];
                                                    }
                                                    ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
<hr>
                            <div class="row total-amount">
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-trans" id="myDataTable">
                                            <thead>
                                                <tr class="bg-our spaces">
                                                    <th> LABOR </th>
                                                    <th> COST </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                            $id = $row['id'];
                                            $lquery = "SELECT *
                                                FROM rprq
                                                INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                INNER JOIN rp_labor ON rprq.id = rp_labor.rprq_rl_id
                                                INNER JOIN common_repairs ON rp_labor.comrep_id = common_repairs.comrep_id
                                                WHERE rprq.id = $id";

                                            $lresult = mysqli_query($conn, $lquery);

                                            // Initialize the labor subtotal
                                            $labor_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $labor_subtotal += $lrow['comrep_cost'];
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['comrep_name'] . '</td>';
                                                echo '<td>' . $lrow['comrep_cost'] . '</td>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the labor subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td class="text-end labortotal"> Labor Subtotal:  </td>';
                                            echo '<td class="labortotal bold">' . $labor_subtotal .".00". '</td>';
                                            echo '</tr>';
                                            
                                            
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 grid-margin">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-trans" id="myDataTable">
                                            <thead>
                                                <tr class="bg-our spaces">
                                                    <th> Part name </th>
                                                    <th> price </th>
                                                    <th> qty </th>
                                                    <th> total </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                            $id = $row['id'];
                                            $lquery = "SELECT *
                                                FROM rprq
                                                INNER JOIN customer ON rprq.Cust_id = customer.Cust_id
                                                INNER JOIN rp_brand_parts ON rprq.id = rp_brand_parts.rprq_id
                                                INNER JOIN brand_parts ON rp_brand_parts.bp_id = brand_parts.bp_id
                                                WHERE rprq.id = $id";

                                            $lresult = mysqli_query($conn, $lquery);

                                            // Initialize the labor subtotal
                                            $partqty = 0;
                                            $part_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $partqty  = $lrow['bp_cost'] * $lrow['quantity'];
                                                $part_subtotal += $partqty;
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['bp_name'] . '</td>';
                                                echo '<td>' . $lrow['bp_cost'] . '</td>';
                                                echo '<td>' . $lrow['quantity'] . '</td>';
                                                echo '<td>' . $partqty . '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the parts subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-end labortotal"> Parts Subtotal:  </td>';
                                            echo '<td class="labortotal">' . $part_subtotal .".00". '</td>';
                                            echo '</tr>';

                                            echo '<tr class="spaces">';
                                            echo '<td colspan="4" class="text-end"> </td>';
                                            echo '</tr>';
                                            $total = $part_subtotal+$labor_subtotal;
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-end"> Total:  </td>';
                                            echo '<td class="">' . $total .".00". '</td>';
                                            echo '</tr>';

                                            if(!empty($row['initial_payment'])){
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-end"> Initial Payment:  </td>';
                                            echo '<td class="">'."- " . $row['initial_payment'] .'</td>';
                                            echo '</tr>';
                                        }


                                            
                                            $grand_total = $total-$row['initial_payment'];


                                            
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center grandtotal">
                                <h4>Total Payable Amount: <?php echo $grand_total.".00"?></h4>
                                <?php if($row['rprq_status'] == 'Completed'){
                            echo '<span class="grandspan">Paid <i class="far fa-money-check-edit-alt"></i></span>';
                        } ?>
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

                    <script>
                    // Add click event listener to toggle buttons
                    const toggleBtns = document.querySelectorAll('.toggle-btn');
                    toggleBtns.forEach((toggleBtn) => {
                        toggleBtn.addEventListener('click', () => {
                            // Toggle the active class on click
                            toggleBtn.classList.toggle('active');
                            // Toggle the visibility of the content cell
                            const contentCell = toggleBtn.parentNode.querySelector('.toggle-content');
                            contentCell.classList.toggle('d-none');
                        });
                    });

                    // Set initial content
                    const laborTotal = document.querySelector('.labortotal').textContent;
                    document.querySelector('.toggle-row:nth-child(1) .toggle-content').textContent = laborTotal;
                    const partsTotal = document.querySelector('.partstotal').textContent;
                    document.querySelector('.toggle-row:nth-child(2) .toggle-content').textContent = partsTotal;
                    </script>

</body>

</html>