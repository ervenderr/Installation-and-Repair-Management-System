<?php
include_once('../admin_includes/header.php');
include_once('../homeincludes/dbconfig.php');

$rowid = $_GET['rowid'];

// Perform the query to delete the row from the customer table
$query = "DELETE FROM `products` WHERE products.product_id = '" . $rowid . "';";
$result = mysqli_query($conn, $query);

if ($result) {
    $msg2 = "Record Successfully deleted";
    header("location: products.php?msg2=" . urlencode($msg2));
}
?>
