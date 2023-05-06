<?php
// get_brands.php

require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['elec_id'])) {
    $elec_id = $_POST['elec_id'];

    $sql = "SELECT * FROM brand_electronics
    LEFT JOIN electronics ON brand_electronics.electronic_id = electronics.elec_id
    LEFT JOIN elec_brand ON brand_electronics.brand_id = elec_brand.eb_id
            WHERE electronic_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $elec_id);
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