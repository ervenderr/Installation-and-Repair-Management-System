<?php
session_start();
if (!isset($_SESSION['logged_id'])) {
    header('location: ../login/login.php');
}

if (!isset($_SESSION['sreq_id'])) {
    header('location: ../service/pending-transaction.php');
}

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = '';
$servicetransac = 'account-active';
include_once('../homeIncludes/header.php');


$transaction_code = $_SESSION['transaction_id'];
$user_id = $_SESSION['logged_id'];

$query = "SELECT service_request.*, 
technician.fname AS tech_fname, 
technician.lname AS tech_lname, 
technician.phone AS tech_phone,
technician.status AS tech_status, 
customer.fname AS cust_fname, 
customer.lname AS cust_lname, 
customer.phone AS cust_phone,
service_request.status AS sr_status, 
accounts.*,
technician.*,
sr_timeline.*,
services.*,
package.*,
customer.*,
(
    SELECT GROUP_CONCAT(CONCAT(t.fname, ' ', t.lname))
    FROM service_request_technicians srt
    JOIN technician t ON srt.tech_id = t.tech_id
    WHERE srt.sreq_id = service_request.sreq_id
    GROUP BY srt.sreq_id
) AS tech_names,
(
    SELECT GROUP_CONCAT(t.phone)
    FROM service_request_technicians srt
    JOIN technician t ON srt.tech_id = t.tech_id
    WHERE srt.sreq_id = service_request.sreq_id
    GROUP BY srt.sreq_id
) AS tech_phones
FROM service_request
LEFT JOIN sr_timeline ON service_request.sreq_id = sr_timeline.sreq_id
LEFT JOIN services ON service_request.service_id = services.service_id
LEFT JOIN package ON service_request.pkg_id = package.pkg_id
LEFT JOIN customer ON service_request.cust_id = customer.cust_id
LEFT JOIN accounts ON customer.account_id = accounts.account_id
LEFT JOIN technician ON technician.tech_id = (
SELECT tech_id
FROM service_request_technicians
WHERE sreq_id = service_request.sreq_id
LIMIT 1
)
WHERE accounts.account_id = '{$user_id}' AND service_request.transaction_code = '{$transaction_code}'
ORDER BY sr_timeline.tm_date DESC, sr_timeline.tm_time DESC;";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
}

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

?>

<body class="view-body">
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
                            if($row['sr_status'] == 'Pending'){
                                $href = 'pending-transaction.php';
                            }elseif($row['sr_status'] == 'In-progress'){
                                $href = 'repairing-transaction.php';
                            }elseif($row['sr_status'] == 'To Pickup' || $row['sr_status'] == 'To Deliver'){
                                $href = 'pickup-transaction.php';
                            }elseif($row['sr_status'] == 'Completed'){
                                $href = 'completed-transaction.php';
                            }
                            ?>
                            <div class="col-6"><a href="<?php echo $href ?>"><i class="fas fa-chevron-left"></i>
                                    Back</a></div>
                            <div class="col-6 nav-cont">
                                <span>REQUEST ID: <?php echo $row['transaction_code']?></span>
                                <span class="half">|</span>
                                <span class="stats">REQUEST <?php echo $row['sr_status']?></span>
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
                        $content = 'Request received, we will contact you shortly.';
                    } elseif ($row2['tm_status'] == 'In-progress') {
                        $content = 'Waiting for payment';
                    }  elseif ($row2['tm_status'] == 'Underway') {
                        $content = 'Currently working';
                    } elseif ($row2['tm_status'] == 'Awaiting Parts') {
                        $content = 'The service is on hold because the necessary parts are not available';
                    }  elseif ($row2['tm_status'] == 'Completed') {
                        $content = 'Service request completed successfully';
                    } elseif ($row2['tm_status'] == 'Cancelled') {
                        $content = 'Service request cancelled';
                    }

                    $status = $row2['tm_status'];
                    $date = $row2['tm_date'];
                    $time = date("h:i a", strtotime($row2['tm_time']));
                    $isCurrentStatus = $row2['tm_status'];
                    $statusClass = $isCurrentStatus ? 'status-intransit' : 'status-delivered';
                    $latestClass = $first ? 'latest' : '';
            ?>
                                    <div
                                        class="tracking-item <?php echo $isCurrentStatus ? 'current-status' : ''; ?> <?php echo $latestClass; ?>">
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
                                    <div class="col-sm-2">
                                        <div class="trans_image center">
                                            <?php
        $imageData = base64_encode($row['image']);
        $src = 'data:image/jpeg;base64,'.$imageData;
        echo '<img src="'.$src.'" id="main_product_image" width="350">';
    ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Transaction
                                                #:</span>
                                            <span class="text-primary"><?php echo $row['transaction_code']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Status:</span>
                                            <span
                                                class="transaction-details-pending"><?php echo $row['sr_status']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Service
                                                Type:</span>
                                            <span><?php echo $row['service_name']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Package
                                                Type:</span>
                                            <span
                                                class="transaction-details-none text-secondary"><?php echo $row['name']?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Date
                                                Requested:</span>
                                            <span><?php echo $row['date_req']?></span>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Estimated
                                                Completion:</span>

                                            <?php
                                                    if($row['dat_date'] == ''){
                                                        echo '<span class="tbh">';
                                                        echo '<i class="fas fa-exclamation-circle"></i>' . 'TBA';
                                                        echo '</span>';
                                                    }else{
                                                        echo $row['dat_date'] . " day(s)";
                                                    }
                                                    ?>

                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Assigned
                                                Technician:</span>
                                            <?php
                                                    if($row['tech_names'] == ''){
                                                        echo '<span class="tbh">';
                                                        echo '<i class="fas fa-exclamation-circle"></i>' . 'TBA';
                                                        echo '</span>';
                                                    }else{
                                                        echo $row['tech_names'] . " day(s)";
                                                    }
                                                    ?>
                                        </div>
                                        <div class="transaction-details-row">
                                            <span class="fw-bold me-2 transaction-details-label">Technician's
                                                Contact:</span>
                                            <?php
                                                    if($row['tech_phones'] == ''){
                                                        echo '<span class="tbh">';
                                                        echo '<i class="fas fa-exclamation-circle"></i>' . 'TBA';
                                                        echo '</span>';
                                                    }else{
                                                        echo $row['tech_phones'];
                                                    }
                                                    ?>
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <form method="post" action="../repair-invoice/booking-repair-pdf.php"
                                            target="_blank">
                                            <?php if ($row['sr_status'] == 'Pending') { ?>
                                            <button type="submit" name="download" value="<?php echo $row['sreq_id']; ?>"
                                                class="btn btn-secondary">
                                                Download Ticket <i class="fas fa-download"></i>
                                            </button>
                                            <?php } ?>

                                        </form>
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
                                                    <th> Package Name </th>
                                                    <th> COST </th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                <?php
                                            $id = $row['sreq_id'];

                                            $lquery = "SELECT *
                                            FROM service_request
                                            LEFT JOIN package ON service_request.pkg_id = package.pkg_id
                                            WHERE service_request.transaction_code = '{$transaction_code}'";

                                            $lresult = mysqli_query($conn, $lquery);

                                            // Initialize the labor subtotal
                                            $labor_subtotal = 0;

                                            while ($lrow = mysqli_fetch_assoc($lresult)) {
                                                // Add the comrep_cost to the labor subtotal
                                                $labor_subtotal += $lrow['price'];
                                            
                                                echo '<tr>';
                                                echo '<td>' . $lrow['name'] . '</td>';
                                                echo '<td>' . number_format($lrow['price'], 2) . '</td>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            
                                            // Moved the labor subtotal row outside the while loop
                                            echo '<tr>';
                                            echo '<td class="text-end labortotal"> Labor Subtotal:  </td>';
                                            echo '<td class="Sub Total">' . number_format($labor_subtotal, 2) . '</td>';
                                            echo '</tr>';



                                            echo '<tr class="spaces">';
                                            echo '<td colspan="4" class="text-end"> </td>';
                                            
                                            if(!empty($row['discount'])){
                                                echo '<tr>';
                                                echo '<td class="text-end"> Discount:  </td>';
                                                echo '<td class="">'. number_format($row['discount'], 2) .'</td>';
                                                echo '</tr>';
                                            }


                                            
                                            $grand_total = $labor_subtotal-$row['discount'];
                                            
                                            
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center grandtotal">
                                    <h4>Total Payable Amount: <?php echo number_format($grand_total, 2) ?></h4>
                                    <?php if($row['sr_status'] == 'Completed'){
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