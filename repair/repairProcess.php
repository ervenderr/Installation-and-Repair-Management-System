<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$transaction_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 11);
$cust_id = $_SESSION["cust_id"];
if(isset($_POST['etype'])){
    $etype = $_POST['etype'];
}
$defective = htmlentities($_POST['defective']);
$other_defective = htmlentities($_POST['other_defective']);
$other_brand = htmlentities($_POST['other_brand']);
$ebrand = htmlentities($_POST['ebrand']);
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

$_SESSION['transaction_code'] = $transaction_code;
$status = htmlentities("Pending");


if ($defective === "other"){

    $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, eb_id, other_defects, shipping, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "isssssss", $cust_id, $transaction_code, $etype, $ebrand, $other_defective, $shipping, $imgcontent, $status);
    mysqli_stmt_execute($stmt);
    
}elseif ($ebrand === "other"){

    $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, other_brand, defect_id, shipping, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "isssssss", $cust_id, $transaction_code, $etype, $other_brand, $defective, $shipping, $imgcontent, $status);
    mysqli_stmt_execute($stmt);
    
}elseif ($ebrand === "other" && $defective === "other"){

    $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, other_brand, other_defects, shipping, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "isssssss", $cust_id, $transaction_code, $etype, $other_brand, $other_defective, $shipping, $imgcontent, $status);
    mysqli_stmt_execute($stmt);
    
}else{

    $query = "INSERT INTO rprq (cust_id, transaction_code, elec_id, eb_id, defect_id, shipping, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "isssssss", $cust_id, $transaction_code, $etype, $ebrand, $defective, $shipping, $imgcontent, $status);
    mysqli_stmt_execute($stmt);

}
?>

