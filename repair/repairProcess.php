<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$cust_id = $_SESSION["cust_id"];
$transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
$fname = htmlentities($_POST['fname']);
$mname = htmlentities($_POST['mname']);
$lname = htmlentities($_POST['lname']);
$email = htmlentities($_POST['email']);
$phone = htmlentities( $_POST['phone']);
$address = htmlentities($_POST['address']);
if(isset($_POST['etype'])){
    $etype = $_POST['etype'];
}
$defective = htmlentities($_POST['defective']);
$shipping = $_POST['shipping'];
$imgcontent = "";
if(!empty($_FILES['eimg']['name'])){
    $filename = $_FILES['eimg']['name'];
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    $allowedtypes = array('png', 'jpg', 'jpeg', 'gif');
    if(in_array($filetype,$allowedtypes)){
        $image = $_FILES['eimg']['tmp_name'];
        $imgcontent = addslashes(file_get_contents($image));
    }
}

$query = "INSERT INTO rprq (cust_id, transaction_code, etype, defective, shipping, image) VALUES ('$cust_id', '$transaction_code', '$etype', '$defective', '$shipping', '".$imgcontent."')";
$result = mysqli_query($conn, $query);




?>