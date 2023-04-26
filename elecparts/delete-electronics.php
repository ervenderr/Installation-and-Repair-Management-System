<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

$id = $_GET['rowid'];

        $delete_associations_query = "DELETE FROM brand_electronics WHERE electronic_id = ?";
        $delete_associations_stmt = mysqli_prepare($conn, $delete_associations_query);
        mysqli_stmt_bind_param($delete_associations_stmt, 'i', $id);
        mysqli_stmt_execute($delete_associations_stmt);

if ($delete_associations_stmt) {
    $query = "DELETE FROM `electronics` WHERE electronics.elec_id = '" . $id . "';";
    $result = mysqli_query($conn, $query);

    $_SESSION['msg2'] = "Record Updated Successfully";
    header("location: parts.php");
} else {
    echo "FAILED: " . mysqli_error($conn);
}
?>
