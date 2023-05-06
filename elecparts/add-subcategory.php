<?php
session_start();

require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])) {
    $subname = htmlentities($_POST['subname']);
    $electronic_type = htmlentities($_POST['electronic_type']);
    


    $query = "INSERT INTO elec_sub_categ (subcateg_name, elec_id) VALUES ('$subname', '$electronic_type');";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['msg'] = "Record Updated Successfully";
        header("Location: sub-category.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}
?>
