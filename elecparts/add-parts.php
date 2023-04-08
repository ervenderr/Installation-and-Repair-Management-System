<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $partname = htmlentities($_POST['partname']);
    $electronic = htmlentities($_POST['electronic']);
    $brand = htmlentities($_POST['brand']);
    $price = htmlentities($_POST['price']);


    $query = "INSERT INTO brand_parts (bp_name, elec_id, eb_id, bp_cost) VALUES ('$partname', '$electronic', '$brand', '$price');";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: parts.php");
    } else {
       echo "FAILED: " . mysqli_error($conn);
    }
}

?>