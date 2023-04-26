<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$id = $_GET['rowid'];

$query = "DELETE FROM `package` WHERE package.pkg_id = '" . $id . "';";
$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['msg2'] = "Record Updated Successfully";
    header("location: packages.php");
}
?>
