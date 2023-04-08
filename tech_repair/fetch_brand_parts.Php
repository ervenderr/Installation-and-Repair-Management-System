<?php
require_once '../homeIncludes/dbconfig.php';

if (isset($_POST['comrep'])) {
    $comrep = $_POST['comrep'];
    $brand_parts = [];

    foreach ($comrep as $comrep_id) {
        $sql = "SELECT * FROM brand_parts WHERE bp_id IN (SELECT brand_parts FROM common_repairs WHERE comrep_id = ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $comrep_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $brand_parts[] = $row;
        }
    }

    echo json_encode($brand_parts);
}
?>
