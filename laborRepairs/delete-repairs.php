<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$id = $_GET['rowid'];

$query = "DELETE FROM `common_repairs` WHERE common_repairs.comrep_id = '" . $id . "';";
$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['msg2'] = "Record Updated Successfully";
    header("location: repairs.php");
}
?>
