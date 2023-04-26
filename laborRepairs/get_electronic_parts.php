<?php


require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['elec_id'])) {
    $elec_id = $_POST['elec_id'];

    $sql = "SELECT * FROM brand_parts 
            WHERE elec_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $elec_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $brand_parts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $brand_parts[] = $row;
    }
    
    if (empty($brand_parts)) {
        echo "No brand parts found";
    } else {
        echo json_encode($brand_parts);
    }

    mysqli_close($conn);
}


?>