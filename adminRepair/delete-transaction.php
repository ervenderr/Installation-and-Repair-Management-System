<?php
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$rowid = $_GET['rowid'];
$tcode = $_GET['transaction_code'];
    
// Perform the query to retrieve the data for the selected row
$query = "SELECT *
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
$query5 = "DELETE FROM `rp_timeline` WHERE rp_timeline.rprq_id = '" . $rowid . "';";
$result5 = mysqli_query($conn, $query5);

$query6 = "DELETE FROM `rp_brand_parts` WHERE rp_brand_parts.rprq_id = '" . $rowid . "';";
$result6 = mysqli_query($conn, $query6);

$query7 = "DELETE FROM `rp_labor` WHERE rp_labor.rprq_rl_id = '" . $rowid . "';";
$result7 = mysqli_query($conn, $query7);

if ($result7) {
    $query6 = "DELETE FROM `rprq` WHERE rprq.transaction_code = '" . $tcode . "';";
    $result6 = mysqli_query($conn, $query6);
    if($result6){

        $_SESSION['msg2'] = "Record Deleted Successfully";
        header("location: transaction.php");
    }else {
        echo "FAILED: " . mysqli_error($conn);
     }
} else {
    echo "FAILED: " . mysqli_error($conn);
 }
?>