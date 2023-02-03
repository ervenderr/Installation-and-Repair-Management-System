<?php
require_once '../homeIncludes/dbconfig.php';


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


$query = "INSERT INTO `service_request`(`fname`, `mname`, `lname`, `email`, `phone`, `address`, `service_id`, `pkg_id`, `other`) VALUES ('$fname', '$mname', '$lname', '$email', '$phone', '$address', '$stype', '$package', '$other')";
$result = mysqli_query($conn, $query);


?>