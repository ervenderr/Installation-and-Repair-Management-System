<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $brandname = htmlentities($_POST['brandname']);
    $query = "INSERT INTO elec_brand (eb_name) VALUES ('$brandname');";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("Location: parts.php"); 
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}
?>
