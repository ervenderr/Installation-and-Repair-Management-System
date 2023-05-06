<?php
// get_subcateg.php

require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['etype_id'])) {
    $etype_id = $_POST['etype_id'];

    $sql = "SELECT * FROM elec_sub_categ WHERE elec_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $etype_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $brand_parts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $brand_parts[] = $row;
    }
    
    if (empty($brand_parts)) {
        echo "No brand found";
    } else {
        echo json_encode($brand_parts);
    }

    mysqli_close($conn);
}


?>