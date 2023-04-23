<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $repairname = htmlentities($_POST['repairname']);
    $electronic = htmlentities($_POST['electronic_type']);
    $electronic_part = htmlentities($_POST['electronic_part']);
    $price = htmlentities($_POST['price']);



        $query = "INSERT INTO common_repairs (comrep_name, elec_id, brand_parts, comrep_cost) VALUES ('$repairname', '$electronic', '$electronic_part', '$price');";

        $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: repairs.php");
    }
}


?>