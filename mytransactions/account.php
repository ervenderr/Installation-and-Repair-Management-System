<?php
session_start();

if (!isset($_SESSION['logged_id'])) {
    header('location: ../login/login.php');
}

require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Home';
$home = '';
$accsetting = 'account-active';
include_once('../homeIncludes/header.php');

$user_id = $_SESSION['logged_id'];
$sql = "SELECT * FROM accounts, customer WHERE accounts.account_id = $user_id AND customer.account_id=accounts.account_id";
$result = mysqli_query($conn, $sql);
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
                        <a href="../repair/repair-transanction.php" class="<?php echo $repairtransac; ?>">Repair request</a>
                    </div>
                    <div>
                        <a href="../service/service-transaction.php" class="<?php echo $servicetransac; ?>">Service request</a>
                    </div>
                    <div>
                        <a href="../mytransactions/account.php" class="<?php echo $accsetting; ?>">Account setting</a>
                    </div>
                    <div>
                        <a href="../login/logout.php">Logout</a>
                    </div>
                </div>
                <div class="col-sm-9 accform-container">
                    <form class="accform">
                        <h4 class="mb-0 text-center accform-header">Account Details</h4>

                        <div class="form-group rprq">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" value="<?php echo $row['fname']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" value="<?php echo $row['lname']; ?>">
                        </div>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control email" id="email" placeholder="Enter Email" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone" value="<?php echo $row['phone']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address" value="<?php echo $row['address']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter Password">
                        </div>
                        <button type="submit" class="btn btn-primary accbtnsave">Save Changes</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</body>

</html>