<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
$cust_id = $_SESSION["cust_id"];
$fname = htmlentities($_POST['fname']);
$mname = htmlentities($_POST['mname']);
$lname = htmlentities($_POST['lname']);
$email = htmlentities($_POST['email']);
$phone = htmlentities( $_POST['phone']);
$address = htmlentities($_POST['address']);
if(isset($_POST['stype'])){
    $stype = $_POST['stype'];
}
if(isset($_POST['package'])){
    $package = $_POST['package'];
}
$other = $_POST['other'];

$_SESSION['transaction_code'] = $transaction_code;
$status = "Pending";

$query = "INSERT INTO service_request (`cust_id`, `transaction_code`, `service_id`, `pkg_id`, `other`, `status`) VALUES ('$cust_id', '$transaction_code', '$stype', '$package', '$other', '$status')";
$result = mysqli_query($conn, $query);


?>