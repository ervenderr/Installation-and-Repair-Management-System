<?php
session_start();
// error_reporting(0);
if (!isset($_SESSION['logged_id'])) {
    header('location: ../login/login.php');
}

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = '';
$servicetransac = 'account-active';
include_once('../homeIncludes/header.php');


$transaction_code = $_SESSION['transaction_code'];
$user_id = $_SESSION['logged_id'];

$query = "SELECT 
customer.cust_id, 
customer.account_id, 
customer.fname, 
customer.mname, 
customer.lname, 
customer.phone, 
customer.address, 
accounts.account_id, 
accounts.email, 
accounts.password,
accounts.user_type, 
accounts.created_at, 
accounts.updated_at, 
service_request.sreq_id, 
service_request.cust_id, 
service_request.transaction_code, 
service_request.service_id, 
service_request.pkg_id, 
service_request.other, 
service_request.date_req, 
service_request.date_completed, 
services.service_name, 
package.name FROM customer 
LEFT JOIN accounts ON customer.account_id=accounts.account_id 
LEFT JOIN service_request ON service_request.cust_id=customer.cust_id 
AND service_request.transaction_code='{$transaction_code}' 
LEFT JOIN services ON service_request.service_id = services.service_id 
LEFT JOIN package ON service_request.pkg_id = package.pkg_id 
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
                        <a href="../repair/repair-transanction.php" class="<?php echo $repairtransac; ?>">Repair
                            request</a>
                    </div>
                    <div>
                        <a href="../service/service-transaction.php" class="<?php echo $servicetransac; ?>">Service
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
                <div class="col-sm-9 accform">
                    <ul class="nav nav-tabs">
                        <li class="nav-item nav-item-tab">
                            <a class="nav-link accform-active active" aria-current="page"
                                href="repair_transaction.php">To Pay</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link n-active" href=".php">In-progress</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link n-active" href="#">Completed</a>
                        </li>
                    </ul>
                    <div class="d-flex accform accform">
                        <ul class="list-group rounded-0 lggg">
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Transaction Code:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Status:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Customer Name</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Address:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Contact</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Email:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Service Type:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Package:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Date Requested:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Date Completed:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0 lgi">Assigned Technicians:
                            </li>
                            <li class="list-group-item list-group-item-secondary border-right-0">Warranty:</li>
                            <li class="list-group-item list-group-item-secondary border-right-0">Payment:</li>
                        </ul>
                        <ul class="list-group rounded-0 list-group2 lgs">
                            <li class="list-group-item border-left-0 bold-text"><?php echo $row['transaction_code']?>
                            </li>
                            <li class="list-group-item border-left-0 bold-text pending">Pending</li>
                            <li class="list-group-item border-left-0 bold-text">
                                <?php echo $row['fname'] ." " .  $row['lname']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['address']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['phone']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['email']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['service_name']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['name']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['date_req']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['date_completed']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"></li>
                            <li class="list-group-item border-left-0 bold-text lgis"><?php echo $row['account_id']?></li>
                            <li class="list-group-item border-left-0 bold-text lgis"></li>
                        </ul>
                        
                    </div>
                    <button id="download" class="download">Download Ticket</button>
                    
                </div>
                
            </div>
        </div>

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script>
  document.getElementById("download").addEventListener("click", function() {
    const ticket = document.querySelector(".ticket");
    html2canvas(ticket).then(function(canvas) {
      const element = document.createElement("a");
      element.setAttribute("href", canvas.toDataURL("image/png").replace("image/png", "image/octet-stream"));
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