<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $elecname = htmlentities($_POST['elecname']);
    $warranty_number = htmlentities($_POST['warranty_number']);
    $warranty_unit = htmlentities($_POST['warranty_unit']);
    $brands = $_POST['brands']; // Get the array of selected brand IDs


    $query = "INSERT INTO electronics (elec_name, warranty_num, warranty_unit) VALUES ('$elecname', '$warranty_number', '$warranty_unit');";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $new_elec_id = mysqli_insert_id($conn);

        foreach ($brands as $brand_id) {
            $association_query = "INSERT INTO brand_electronics (electronic_id, brand_id) VALUES ('$new_elec_id', '$brand_id')";
            mysqli_query($conn, $association_query);
        }
        $_SESSION['msg'] = "Record Updated Successfully";
        header("Location: parts.php"); 
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}
?>
