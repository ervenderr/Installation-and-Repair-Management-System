<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$id = $_GET['rowid'];

$query = "DELETE FROM `services` WHERE services.service_id = '" . $id . "';";
$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['msg2'] = "Record Updated Successfully";
    header("location: servicelist.php");
}
?>
