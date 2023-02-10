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
$history = 'account-active';
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
                        <a href="../mytransactions/transaction-history.php" class="<?php echo $history; ?>">Transaction
                            History</a>
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
                    <h4 class="mb-0 text-center accform-header">Transaction History</h4>
                    <div class="d-flex accform accform">
                    <div class="card">
                <div class="card-body">
                        <div class="table-responsive pt-3">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction Code</th>
                                        <th>Request type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>$i</td>
                                        <td>'last_name first_name']</td>
                                        <td>email</td>
                                        <td>contact_no</td>
                                        <td>
                                            <div class="action">
                                                <a class="me-2 green" href="view_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-eye"></i></a>
                                                <a class="me-2 green" href="edit_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-edit"></i></a>
                                                <a class="green" href="delete_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>$i</td>
                                        <td>'last_name first_name']</td>
                                        <td>email</td>
                                        <td>contact_no</td>
                                        <td>
                                            <div class="action">
                                                <a class="me-2 green" href="view_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-eye"></i></a>
                                                <a class="me-2 green" href="edit_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-edit"></i></a>
                                                <a class="green" href="delete_tenant.php?id='.$row['id'].'"><i
                                                        class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                </div>
                </div>

            </div>


            <script>
    $('#example').DataTable( {
  responsive: {
    breakpoints: [
      {name: 'bigdesktop', width: Infinity},
      {name: 'meddesktop', width: 1480},
      {name: 'smalldesktop', width: 1280},
      {name: 'medium', width: 1188},
      {name: 'tabletl', width: 1024},
      {name: 'btwtabllandp', width: 848},
      {name: 'tabletp', width: 768},
      {name: 'mobilel', width: 480},
      {name: 'mobilep', width: 320}
    ]
  }
} );
</script>

</body>

</html>