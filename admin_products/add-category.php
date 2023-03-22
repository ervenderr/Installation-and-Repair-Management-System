<?php
session_start();
require_once '../homeIncludes/dbconfig.php';

if(isset($_POST['submit'])){
    $category = $_POST['category'];

    $sql = "INSERT INTO category (categ_name) VALUES (?)";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle error
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $category);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['msg'] = "Category Added Successfully";
            header("location: products.php");
        } else {
            echo "FAILED: " . mysqli_error($conn);
        }
    }
}

?>