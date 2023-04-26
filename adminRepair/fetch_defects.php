<?php
require_once '../homeIncludes/dbconfig.php';


if (isset($_POST['etype_id'])) {
    $etype_id = $_POST['etype_id'];

    $sql = "SELECT * FROM defects WHERE elec_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $etype_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $defects = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $defects[] = $row;
    }
    echo json_encode($defects);

    mysqli_close($conn);
}

?>