<?php
session_start();
include_once('../admin_includes/header.php');
require_once '../homeIncludes/dbconfig.php';
include_once('../tools/variables.php');

$product_id = $_SESSION['rowid'];

// Perform the query to delete the row from the customer table
$query = "DELETE FROM `products` WHERE products.product_id = '" . $product_id . "';";
$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['msg2'] = "Record Updated Successfully";
    header("location: products.php");
}
?>
