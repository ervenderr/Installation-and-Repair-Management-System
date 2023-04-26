<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
$cust_id = $_SESSION["cust_id"];
$pkg_id = htmlentities($_SESSION['pkg_id']);

$query = "SELECT *, package.price AS package_price, services.price AS service_price, package.status AS package_status
FROM package
INNER JOIN services ON package.service_id = services.service_id
WHERE package.PKG_id = '" . $pkg_id . "';";
$result = mysqli_query($conn, $query);


// Check if the query was successful and output the data
if (mysqli_num_rows($result) > 0) {
  $rows = mysqli_fetch_assoc($result);

}

$service_id = htmlentities($rows['service_id']);
$name = htmlentities($rows['name']);
$package_price = htmlentities($rows['package_price']);


$_SESSION['transaction_code'] = $transaction_code;
$status = "Pending";

$query = "INSERT INTO service_request (`cust_id`, `transaction_code`, `service_id`, `pkg_id`, `status`) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "issss", $cust_id, $transaction_code, $service_id, $pkg_id, $status);
mysqli_stmt_execute($stmt);

$newly_inserted_id = mysqli_insert_id($conn);
$tquery = "INSERT INTO sr_timeline (sreq_id, tm_date, tm_time, tm_status) VALUES ('$newly_inserted_id', NOW(), NOW(), '$status');";
$tresult = mysqli_query($conn, $tquery);
?>
