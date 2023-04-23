<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $partname = htmlentities($_POST['partname']);
    $electronic = htmlentities($_POST['electronic_type']);
    $brand = htmlentities($_POST['electronic_type']);
    $price = htmlentities($_POST['price']);

    $sql = "SELECT * FROM brand_electronics
    LEFT JOIN electronics ON brand_electronics.electronic_id = electronics.elec_id
    LEFT JOIN elec_brand ON brand_electronics.brand_id = elec_brand.eb_id
    WHERE electronic_id = $electronic AND brand_id = $brand";

    
        $query = "INSERT INTO brand_parts (bp_name, elec_id, eb_id, bp_cost) VALUES ('$partname', '$electronic', '$brand', '$price');";

        $result = mysqli_query($conn, $query);

        

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("location: parts.php");
    }
}


?>