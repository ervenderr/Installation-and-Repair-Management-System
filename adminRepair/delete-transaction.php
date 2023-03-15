<?php
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT rprq.id, rprq.transaction_code, rprq.status, customer.fname, customer.lname, customer.address, customer.phone, accounts.email, rprq.etype, rprq.defective, rprq.date_req, rprq.date_completed, rprq.shipping
          FROM rprq
          JOIN customer ON rprq.cust_id = customer.cust_id
          JOIN accounts ON customer.account_id = accounts.account_id
          WHERE rprq.transaction_code = '" . $tcode . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

}

?>

<?php
$query6 = "DELETE FROM `rprq` WHERE rprq.transaction_code = '" . $tcode . "';";
$result6 = mysqli_query($conn, $query6);

if ($result6) {
    $msg2 = "Record Successfully deleted";
    header("location: transaction.php?msg2=" . urlencode($msg2));
}
?>